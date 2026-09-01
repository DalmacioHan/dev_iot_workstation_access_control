<?php

namespace App\Http\Controllers;

use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $courses = PcAccessLogs::query()
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $workstations = Workstations::query()
            ->whereNotNull('pc_code')
            ->where('pc_code', '!=', '')
            ->distinct()
            ->orderBy('pc_code')
            ->pluck('pc_code');

        $events = PcAccessLogs::query()
            ->whereNotNull('event_type')
            ->where('event_type', '!=', '')
            ->distinct()
            ->orderBy('event_type')
            ->pluck('event_type');

        $results = PcAccessLogs::query()
            ->whereNotNull('result')
            ->where('result', '!=', '')
            ->distinct()
            ->orderBy('result')
            ->pluck('result');

        $reasons = PcAccessLogs::query()
            ->whereNotNull('reason')
            ->where('reason', '!=', '')
            ->distinct()
            ->orderBy('reason')
            ->pluck('reason');

        $query = DB::table('pc_access_logs')
            ->select(
                'pc_access_logs.id',
                'pc_access_logs.occurred_at',
                'pc_access_logs.course',
                'workstations.pc_code as workstation',
                'pc_access_logs.event_type',
                'pc_access_logs.result',
                'pc_access_logs.reason'
            )
            ->join('workstations', 'pc_access_logs.workstation_id', '=', 'workstations.id');

        if ($request->filled('date_from')) {
            $query->whereDate('pc_access_logs.occurred_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('pc_access_logs.occurred_at', '<=', $request->date_to);
        }

        if ($request->filled('course')) {
            $query->where('pc_access_logs.course', $request->course);
        }

        if ($request->filled('workstation')) {
            $query->where('workstations.pc_code', $request->workstation);
        }

        if ($request->filled('event')) {
            $query->where('pc_access_logs.event_type', $request->event);
        }

        if ($request->filled('result')) {
            $query->where('pc_access_logs.result', $request->result);
        }

        if ($request->filled('reason')) {
            $query->where('pc_access_logs.reason', $request->reason);
        }

        $logs = $query
            ->orderBy('pc_access_logs.occurred_at', 'asc')
            ->paginate(20)
            ->appends($request->query());

        return view('admin.reports.index', compact(
            'logs',
            'courses',
            'workstations',
            'events',
            'results',
            'reasons'
        ));
    }
}
