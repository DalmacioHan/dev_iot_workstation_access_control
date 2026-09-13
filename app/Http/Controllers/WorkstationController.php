<?php
namespace App\Http\Controllers;

use App\Models\Device;
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
        $query = Workstations::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('pc_code', 'like', "%{$search}%");
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
            
        ]);
        DB::transaction(function () use ($validated) {
            $workstation = Workstations::create([
                'pc_code' => $validated['pc_code'],
                'device_id' => $validated['device_id'],
            ]);
        });

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
        $assignment = $workstation->device()->get();
        
        if ($assignment->isEmpty()) {
            return view('admin.workstation.view', compact('workstation'));
        } else {
        $deviceUid = $assignment->first()->device_uid;
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
