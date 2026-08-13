<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(){
        //Card data
        $popularWorkstation = PcAccessLogs::select('workstation_id', PcAccessLogs::raw('count(*) as total'))
            ->with('workstation')
            ->groupBy('workstation_id')
            ->orderBy('total', 'desc')
            ->first();
        $totalEvents = PcAccessLogs::count();
        $failedEvents = PcAccessLogs::where('result', 'FAIL')->count();

        return view('admin.analytics.index', compact('totalEvents', 'failedEvents', 'popularWorkstation'));
    }
}
