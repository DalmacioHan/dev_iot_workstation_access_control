<?php

namespace App\Http\Controllers;

use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        
        $logs = DB::table('pc_access_logs')
            ->select(
                'pc_access_logs.id',
                'pc_access_logs.occurred_at',
                'pc_access_logs.course',
                'workstations.pc_code as workstation',
                'pc_access_logs.event_type',
                'pc_access_logs.result',
                'pc_access_logs.reason'
            )
            ->join('workstations', 'pc_access_logs.workstation_id', '=', 'workstations.id')
            ->orderBy('pc_access_logs.id', 'asc')
            ->paginate(50);

        return view('admin.reports.index', compact('logs'));
    }
}
