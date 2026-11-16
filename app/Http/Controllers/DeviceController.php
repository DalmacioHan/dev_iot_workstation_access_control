<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function __construct(private SessionService $sessions)
    {
    }

    public function index(Request $request)
    {
        $query = Device::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('workstation_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === 'paired' ? 1 : 0;
            $query->where('is_paired', $status);
        }

        $devices = $query->latest()->paginate(5)->withQueryString();

        $inUseDeviceIds = collect();
        if ($devices->count() > 0) {
            $inUseDeviceIds = $this->sessions->openSessionsQuery()
                ->whereIn('pc_access_logs.device_id', $devices->pluck('id'))
                ->distinct()
                ->pluck('pc_access_logs.device_id');
        }

        return view('admin.device.index', compact('devices', 'inUseDeviceIds'));
    }

    public function create(){
        return view('admin.device.add');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'workstation_name'=> 'required|string|max:255|unique:devices,workstation_name',
    ]);
    
    $pairingCode = Device::newPairingCode();

    Device::create([
        'workstation_name'=> trim($validated['workstation_name']),
        'pairing_code' => $pairingCode,
        'is_paired'    => false, 
    ]);

        return redirect()->route('device')
    ->with('success', "Device added successfully! Code: {$pairingCode}")
    ->with('success_redirect', route('device'));

}
    public function update(Request $request, Device $device){
        
        $request->validate([
            'workstation_name' => 'required|string|max:255|unique:devices,workstation_name,' . $device->id,
            'is_paired' => 'required|boolean',
        ]);

        $isPaired = (bool) $request->input('is_paired');
        $workstationName = trim($request->input('workstation_name'));

        if (!$isPaired) {
            // Close any live session so the dashboard stops showing "In Use".
            try {
                $this->sessions->closeOpenSessionsForDevice(
                    $device->id,
                    'Device unpaired by admin',
                    SessionService::ENDED_BY_ADMIN
                );
            } catch (\Throwable $e) {
                // Unpairing should still proceed even if session cleanup fails.
            }

            // Revokes the token, marks the device unpaired, and guarantees a
            // fresh pairing code for the next activation.
            $code = $device->unpair();

            $device->update(['workstation_name' => $workstationName]);

            return redirect()->route('device', $device)
                ->with('success', "Device updated. New pairing code: {$code}");
        }

        // Marking paired manually: clear the one-time code (activation also
        // clears it) but leave the token alone.
        $device->update([
            'workstation_name' => $workstationName,
            'is_paired' => true,
            'pairing_code' => null,
        ]);

        return redirect()->route('device', $device)->with('success', 'Device updated successfully.');
    }
    public function edit(Device $device){
        return view('admin.device.edit', compact('device'));
    }
public function show(Device $device ){
    $commands = $device->remoteCommands()->latest('id')->limit(5)->get();
    $accessLogs = $device->accessLogs()
        ->latest('occurred_at')
        ->limit(5)
        ->get();

    return view('admin.device.view', compact('device', 'commands', 'accessLogs'));
}
    public function destroy($id)
    {
        $device = Device::findOrFail($id);

        // Best effort: close any open sessions tied to this device before removal.
        try {
            $this->sessions->closeOpenSessionsForDevice(
                $device->id,
                'Device deleted by admin',
                SessionService::ENDED_BY_ADMIN
            );
        } catch (\Throwable $e) {
            // Deletion should still proceed even if cleanup fails.
        }

        $device->delete();

        return redirect()->route('device')->with('success', "Device '{$device->workstation_name}' was successfully deleted.");
    }

    public function lockDevice(Request $request, Device $device)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        // Close the session on the server first. This works even when the
        // client is offline, restarted, or showing a stale login.
        $closed = $this->sessions->closeOpenSessionsForDevice(
            $device->id,
            'Remote lock by staff',
            SessionService::ENDED_BY_ADMIN
        );

        $device->remoteCommands()->create([
            'command' => 'lock',
            'message' => trim($validated['message'] ?? '') ?: null,
            'status'  => 'pending',
        ]);

        $name = $device->workstation_name;
        $sessionNote = $closed > 0
            ? " {$closed} open session" . ($closed === 1 ? ' was' : 's were') . ' closed.'
            : '';

        return redirect()->back()->with('success', "Remote lock command sent to '{$name}'. It will take effect on the PC's next check (within a few seconds if online).{$sessionNote}");
    }

    public function announceDevice(Request $request, Device $device)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $device->remoteCommands()->create([
            'command' => 'announcement',
            'message' => trim($validated['message']),
            'status'  => 'pending',
        ]);

        $name = $device->workstation_name;

        return redirect()->back()->with('success', "Announcement sent to '{$name}'. It will display on the PC within a few seconds if online.");
    }

    public function bulkLock(Request $request)
    {
        $validated = $request->validate([
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'integer|exists:devices,id',
            'message' => 'nullable|string|max:500',
        ]);

        $devices = Device::whereIn('id', $validated['device_ids'])->get();
        $locked = 0;
        $closedSessions = 0;

        foreach ($devices as $device) {
            $closedSessions += $this->sessions->closeOpenSessionsForDevice(
                $device->id,
                'Remote lock by staff',
                SessionService::ENDED_BY_ADMIN
            );

            $device->remoteCommands()->create([
                'command' => 'lock',
                'message' => trim($validated['message'] ?? '') ?: null,
                'status'  => 'pending',
            ]);

            $locked++;
        }

        return redirect()->back()->with('success', "Remote lock sent to {$locked} device(s). {$closedSessions} open session(s) closed.");
    }

    public function bulkAnnounce(Request $request)
    {
        $validated = $request->validate([
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'integer|exists:devices,id',
            'message' => 'required|string|max:500',
        ]);

        $devices = Device::whereIn('id', $validated['device_ids'])->get();
        $count = 0;

        foreach ($devices as $device) {
            $device->remoteCommands()->create([
                'command' => 'announcement',
                'message' => trim($validated['message']),
                'status'  => 'pending',
            ]);
            $count++;
        }

        return redirect()->back()->with('success', "Announcement sent to {$count} device(s).");
    }

    public function unlockDevice(Request $request, Device $device)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        $device->remoteCommands()->create([
            'command' => 'unlock',
            'message' => trim($validated['message'] ?? '') ?: null,
            'status'  => 'pending',
        ]);

        $name = $device->workstation_name;

        return redirect()->back()->with('success', "Remote unlock command sent to '{$name}'. It will unlock on the PC's next check (within a few seconds if online). No student session will be started.");
    }

    public function bulkUnlock(Request $request)
    {
        $validated = $request->validate([
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'integer|exists:devices,id',
            'message' => 'nullable|string|max:500',
        ]);

        $devices = Device::whereIn('id', $validated['device_ids'])->get();
        $count = 0;

        foreach ($devices as $device) {
            $device->remoteCommands()->create([
                'command' => 'unlock',
                'message' => trim($validated['message'] ?? '') ?: null,
                'status'  => 'pending',
            ]);
            $count++;
        }

        return redirect()->back()->with('success', "Remote unlock sent to {$count} device(s). No student sessions were started.");
    }

    public function bulkDestroy(Request $request)
    {
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'device_ids' => 'required|array|min:1',
            'device_ids.*' => 'integer|exists:devices,id',
        ]);

        $devices = Device::whereIn('id', $validated['device_ids'])->get();
        $deleted = 0;

        foreach ($devices as $device) {
            try {
                $this->sessions->closeOpenSessionsForDevice(
                    $device->id,
                    'Device deleted by admin',
                    SessionService::ENDED_BY_ADMIN
                );
            } catch (\Throwable $e) {
                // Best effort.
            }

            $device->delete();
            $deleted++;
        }

        return redirect()->back()->with('success', "{$deleted} device(s) deleted.");
    }
}