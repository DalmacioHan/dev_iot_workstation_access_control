<?php

namespace App\Http\Controllers;

use App\Models\PcAccessLogs;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Enums\Format;

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

            $devices = Device::query()
            ->select('device_uid', 'workstation_name') 
            ->whereNotNull('workstation_name')
            ->where('workstation_name', '!=', '')
            ->distinct()
            ->orderBy('workstation_name')
            ->pluck('workstation_name', 'device_uid'); 

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

        $columns = $this->selectedColumns($request);

        return view('admin.reports.index', compact(
            'logs',
            'courses',
            'devices',
            'events',
            'results',
            'reasons',
            'columns'
        ));
    }

    public function exportCsv(Request $request)
    {
        $filename = 'access-report-' . now()->format('Y-m-d_H-i-s') . '.csv';
        $includeCourse = $this->selectedColumns($request)['course'];
        return response()->streamDownload(function () use ($request, $includeCourse) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");
            $headers = [
                'ID',
                'Date & Time',
                'Device',
                'Event',
                'Result',
                'Reason',
            ];

            if ($includeCourse) {
                array_splice($headers, 2, 0, ['Course']);
            }

            fputcsv($handle, $headers);

            $this->filteredLogsQuery($request)
                ->orderBy('pc_access_logs.occurred_at', 'asc')
                ->cursor()
                ->each(function ($log) use ($handle, $includeCourse) {
                    $row = [
                        $log->id,
                        $log->occurred_at,
                        $log->device,
                        $log->event_type,
                        $log->result,
                        $log->reason,
                    ];

                    if ($includeCourse) {
                        array_splice($row, 2, 0, [$log->course]);
                    }

                    fputcsv($handle, $row);
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(Request $request)
    {
        return $this->reportPdf($request)->download($this->reportFilename());
    }

    public function previewPdf(Request $request)
    {
        $logs = $this->filteredLogsQuery($request)
            ->orderBy('pc_access_logs.occurred_at', 'asc')
            ->get();

        return Pdf::view('admin.reports.pdf', [
            'logs' => $logs,
            'columns' => $this->selectedColumns($request),
        ])
            ->headerView('admin.reports.header')
            ->footerView('admin.reports.footer')
            
            ->margins(45, 15, 35, 15, Unit::Millimeter)
            ->format(Format::A4)
            ->inline('access-report-preview.pdf');
    }

    private function reportPdf(Request $request)
    {
        $logs = $this->filteredLogsQuery($request)
            ->orderBy('pc_access_logs.occurred_at', 'asc')
            ->get();

        return Pdf::view('admin.reports.pdf', [
            'logs' => $logs,
            'columns' => $this->selectedColumns($request),
            'filters' => $request->only([
                'date_from',
                'date_to',
                'course',
                'device',
                'event',
                'result',
                'reason',
            ]),
            'generatedAt' => now(),
        ])
        ->headerView('admin.reports.header')
        ->footerView('admin.reports.footer')
        ->margins(45, 15, 35, 15, Unit::Millimeter)
        ->format(Format::A4);
    }

    private function reportFilename(): string
    {
        return 'access-report-' . now()->format('Y-m-d_H-i-s') . '.pdf';
    }

    private function selectedColumns(Request $request): array
    {
        if (!$request->boolean('columns_configured')) {
            return [
                'student_name' => true,
                'course' => true,
                'device' => true,
                'date_time' => true,
                'event' => true,
            ];
        }

        $requestedColumns = $request->input('cols', []);

        return [
            'student_name' => array_key_exists('student_name', $requestedColumns),
            'course' => array_key_exists('course', $requestedColumns),
            'device' => array_key_exists('device', $requestedColumns),
            'date_time' => array_key_exists('date_time', $requestedColumns),
            'event' => array_key_exists('event', $requestedColumns),
        ];
    }

    private function filteredLogsQuery(Request $request)
    {
        $query = DB::table('pc_access_logs')
            ->select(
                'pc_access_logs.id',
                'pc_access_logs.occurred_at',
                'pc_access_logs.student_name',
                'pc_access_logs.course',
                'devices.workstation_name as workstation_name',
                'pc_access_logs.event_type',
                'pc_access_logs.result',
                'pc_access_logs.reason'
            )
            ->join('devices', 'pc_access_logs.device_id', '=', 'devices.id');

        if ($request->filled('date_from')) {
            $query->whereDate('pc_access_logs.occurred_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('pc_access_logs.occurred_at', '<=', $request->date_to);
        }

        if ($request->filled('course')) {
            $query->where('pc_access_logs.course', $request->course);
        }

        if ($request->filled('device')) {
            $query->where('devices.w', $request->device);
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