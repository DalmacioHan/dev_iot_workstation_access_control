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
            $query->where(function($q) use ($search) {
                $q->where('workstation_name', 'like', "%{$search}%");
                
            });
        }


        if ($request->filled('status')) {
            $status = $request->input('status') === 'paired' ? 1 : 0;
            $query->where('is_paired', $status);
        }
        $devices = $query->latest()->paginate(5)->withQueryString();

    
        return view('admin.device.index', compact('devices'));
    }

    public function create(){
        return view('admin.device.add');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'workstation_name'=> 'required|string|max:255|unique:devices,workstation_name',
    ]);
    
    $pairingCode = strtoupper(Str::random(6));

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

        // If unpairing (or keeping unpaired), clear token/last pairing so it can be paired again.
        if (!$isPaired) {
            $device->revokeToken();
        }

        $device->update([
            'workstation_name' => $workstationName,
            'is_paired' => $isPaired,
            'last_seen_at' => $isPaired ? $device->last_seen_at : null,
        ]);

        $message = 'Device updated successfully.';

        // Ensure an unpaired device always has a pairing code available.
        if (!$isPaired && empty($device->fresh()->pairing_code)) {
            $code = strtoupper(Str::random(6));

            $device->update(['pairing_code' => $code]);

            $message = "Device updated. New pairing code: {$code}";
        }

        // If marked paired manually without an active token context, keep state consistent.
        if ($isPaired) {
            // pairing_code is normally cleared on activation; keep as-is if already paired.
            $device->update(['pairing_code' => null]);
        }

        return redirect()->route('device', $device)->with('success', $message);
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
    
}