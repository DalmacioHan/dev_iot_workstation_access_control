<?php
namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceWorkstation;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class WorkstationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $deviceWorkstations = DeviceWorkstation::with(['workstation', 'device'])->get();
        return view('admin.workstation.index', compact('deviceWorkstations'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    $fullDeviceIds = DeviceWorkstation::groupBy('device_id')
        ->havingRaw('COUNT(*) >= 2')
        ->pluck('device_id');


    $device = Device::where('is_active', true)
        ->whereNotIn('id', $fullDeviceIds)
        ->get();

    
    $usedPortsByDevice = DeviceWorkstation::whereIn('pc_port', ['1', '2'])
        ->get()
        ->groupBy('device_id')
        ->map(function ($items) {
            return $items->pluck('pc_port')->toArray();
        });

    return view('admin.workstation.add', compact('device', 'usedPortsByDevice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pc_code'   => 'required|string|max:100|unique:workstations,pc_code',
            'device_id' => 'required|exists:devices,id',
            'pc_port'   => 'required|in:1,2',
        ]);

        $portAlreadyUsed = DeviceWorkstation::where('device_id', $validated['device_id'])
            ->where('pc_port', $validated['pc_port'])
            ->exists();

        if ($portAlreadyUsed) {
            return back()
                ->withInput()
                ->withErrors(['pc_port' => 'Selected port is already used for this device.']);
        }

        try {
            DB::transaction(function () use ($validated) {
                $workstation = Workstations::create([
                    'pc_code' => $validated['pc_code'],
                ]);

                DeviceWorkstation::create([
                    'device_id'      => $validated['device_id'],
                    'pc_port'        => $validated['pc_port'],
                    'workstation_id' => $workstation->id,
                ]);
            });
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['general' => 'Failed to save workstation or link to device.']);
        }

        return redirect()->route('workstation')
            ->with('success', 'Workstation added successfully!')
            ->with('success_redirect', route('workstation'));
    }

    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workstation = Workstations::findOrFail($id);
        $workstation = Workstations::with('deviceWorkstations.device')->find($id);;
        $assignment = $workstation->deviceWorkstations->first();
        if ($assignment && $assignment->device) {
        $deviceUid = $assignment->device->device_uid;
        return view('admin.workstation.view', compact('workstation', 'deviceUid'));
    }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
