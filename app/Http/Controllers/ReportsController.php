<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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

        $logs = $this->filteredLogsQuery($request)
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

    public function exportCsv(Request $request)
    {
        $filename = 'access-report-' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($request) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'ID',
                'Date & Time',
                'Course',
                'Workstation',
                'Event',
                'Result',
                'Reason',
            ]);

            $this->filteredLogsQuery($request)
                ->orderBy('pc_access_logs.occurred_at', 'asc')
                ->cursor()
                ->each(function ($log) use ($handle) {
                    fputcsv($handle, [
                        $log->id,
                        $log->occurred_at,
                        $log->course,
                        $log->workstation,
                        $log->event_type,
                        $log->result,
                        $log->reason,
                    ]);
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $logs = $this->filteredLogsQuery($request)
            ->orderBy('pc_access_logs.occurred_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', [
            'logs' => $logs,
            'filters' => $request->only([
                'date_from',
                'date_to',
                'course',
                'workstation',
                'event',
                'result',
                'reason',
            ]),
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('access-report-' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    private function filteredLogsQuery(Request $request)
    {
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

        return $query;
    }
}
