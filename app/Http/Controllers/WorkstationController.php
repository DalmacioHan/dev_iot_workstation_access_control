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
    public function index(Request $request)
    {
        $query = DeviceWorkstation::with(['workstation', 'device']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('workstation', function ($q) use ($search) {
                $q->where('pc_code', 'like', "%{$search}%");
            });
        }

        $deviceWorkstations = $query->latest()->paginate(5)->withQueryString();

        return view('admin.workstation.index', compact('deviceWorkstations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        $devicesName = Device::whereNotNull('api_token')
        ->where('is_active', 1)
        ->get(['id', 'device_uid', 'name', 'is_active']);

        return view('admin.workstation.add', compact('devicesName'));
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
        $workstation = Workstations::findOrFail($id);
        return view('admin.workstation.edit', compact('workstation'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        $workstation = Workstations::findOrFail($id);

        $request ->validate([
            'pc_code' => 'required|string|max:100|unique:workstations,pc_code,' . $workstation->id,
            'status'  => 'required|boolean', 
        ]);

        $workstation->update([
            'pc_code'=> $request->input('pc_code'),
            'is_active' => $request->input('status'),
        ]);

        return redirect()->route('workstation')
            ->with('success', 'Workstation updated successfully!');
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $workstation = Workstations::findOrFail($id);
        $workstation->delete();

        return redirect()->route('workstation')
            ->with('success', 'Workstation deleted successfully!');
    }
}
