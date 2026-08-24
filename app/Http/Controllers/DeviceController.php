<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Device::withCount('deviceWorkstations');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('device_uid', 'like', "%{$search}%");
                
            });
        }


        if ($request->filled('status')) {
            $status = $request->input('status') === 'active' ? 1 : 0;
            $query->where('is_active', $status);
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
        'device_uid' => 'required|string|max:100|unique:devices,device_uid',
        'name'       => 'required|string|max:255',
    ]);
    
    $pairingCode = strtoupper(Str::random(6));

    Device::create([
        'device_uid'   => $validated['device_uid'],
        'name'         => $validated['name'],
        'pairing_code' => $pairingCode,
        'is_active'    => false, 
    ]);

        return redirect()->route('device')
    ->with('success', "Device added successfully! Code: {$pairingCode}")
    ->with('success_redirect', route('device'));

}
    public function update(Request $request, Device $device){
        
        $request->validate([
            'name' => 'required',
            'is_active' => 'required|boolean',
        ]);

        $device->update([
            'name' => $request->input('name'),
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('device.edit', $device)->with('success', 'Device updated successfully.');
    }
    public function edit(Device $device){
        return view('admin.device.edit', compact('device'));
    }
    public function show(Device $device ){
        
        $device= Device::where('id',$device->id)->first();
        $deviceSlot= $device->deviceWorkstations()->with('workstation')->get();
        $assignedWorkstations= Workstations::wherehas('deviceWorkstations', function($q) use ($device) {
            $q->where('device_id', $device->id);
        })->get();
        
        return view('admin.device.view', compact('device', 'deviceSlot','assignedWorkstations'));
    }
    public function destroy($id)
    {
    
        $device = Device::findOrFail($id);
        if ($device->is_active) { 
            return redirect()->route('device')
                ->with('error', "Cannot delete device '{$device->name}' because it is currently Active. Please deactivate it before attempting to delete.");
        }

        if ($device->deviceWorkstations->count() > 0) {
            return redirect()->route('device')
                ->with('error', "Cannot delete device '{$device->name}' because it is currently assigned to one or more workstations. Please unassign it from all workstations before attempting to delete.");
        }
        $device->delete();

        return redirect()->route('device')->with('success', "Device '{$device->name}' was successfully deleted.");
    }
}