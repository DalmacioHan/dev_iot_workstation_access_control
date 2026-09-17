<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Device::query();

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
        'workstation_name'=> 'required|string|max:255',
    ]);
    
    $pairingCode = strtoupper(Str::random(6));

    Device::create([
        'device_uid'   => $validated['device_uid'],
        'workstation_name'=> $validated['workstation_name'],
        'pairing_code' => $pairingCode,
        'is_active'    => false, 
    ]);

        return redirect()->route('device')
    ->with('success', "Device added successfully! Code: {$pairingCode}")
    ->with('success_redirect', route('device'));

}
    public function update(Request $request, Device $device){
        
        $request->validate([
            'workstation_name' => 'required',
            'is_active' => 'required|boolean',
        ]);

        $device->update([
            'workstation_name' => $request->input('workstation_name'),
            'is_active' => $request->input('is_active'),
        ]);

        

        return redirect()->route('device', $device)->with('success', 'Device updated successfully.');
    }
    public function edit(Device $device){
        return view('admin.device.edit', compact('device'));
    }
    public function show(Device $device ){
        return view('admin.device.view', compact('device'));
    }
    public function destroy($id)
    {
    
        $device = Device::findOrFail($id);
        if ($device->is_active) { 
            return redirect()->route('device')
                ->with('error', "Cannot delete device '{$device->workstation_name}' because it is currently Active. Please deactivate it before attempting to delete.");
        }

        
        $device->delete();

        return redirect()->route('device')->with('success', "Device '{$device->device_uid}' was successfully deleted.");
    }
}