<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class ReportsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Reports Page
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Course Filter Options
        |--------------------------------------------------------------------------
        */
        $courses = PcAccessLogs::query()
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');


        /*
        |--------------------------------------------------------------------------
        | Device / Workstation Filter Options
        |--------------------------------------------------------------------------
        */
        $devices = Device::query()
            ->whereNotNull('workstation_name')
            ->where('workstation_name', '!=', '')
            ->distinct()
            ->orderBy('workstation_name')
            ->pluck('workstation_name');


        /*
        |--------------------------------------------------------------------------
        | Event Filter Options
        |--------------------------------------------------------------------------
        */
        $events = PcAccessLogs::query()
            ->whereNotNull('event_type')
            ->where('event_type', '!=', '')
            ->distinct()
            ->orderBy('event_type')
            ->pluck('event_type');


        /*
        |--------------------------------------------------------------------------
        | Result Filter Options
        |--------------------------------------------------------------------------
        */
        $results = PcAccessLogs::query()
            ->whereNotNull('result')
            ->where('result', '!=', '')
            ->distinct()
            ->orderBy('result')
            ->pluck('result');


        /*
        |--------------------------------------------------------------------------
        | Reason Filter Options
        |--------------------------------------------------------------------------
        */
        $reasons = PcAccessLogs::query()
            ->whereNotNull('reason')
            ->where('reason', '!=', '')
            ->distinct()
            ->orderBy('reason')
            ->pluck('reason');


        /*
        |--------------------------------------------------------------------------
        | Access Logs
        |--------------------------------------------------------------------------
        |
        | Search + filters are all handled by filteredLogsQuery().
        |
        */
        $logs = $this->filteredLogsQuery($request)
            ->orderBy('pc_access_logs.occurred_at', 'asc')
            ->paginate(20)
            ->appends($request->query());


        /*
        |--------------------------------------------------------------------------
        | Visible Table / Export Columns
        |--------------------------------------------------------------------------
        */
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


    /*
    |--------------------------------------------------------------------------
    | Export CSV
    |--------------------------------------------------------------------------
    */
    public function exportCsv(Request $request)
    {
        $filename =
            'access-report-' .
            now()->format('Y-m-d_H-i-s') .
            '.csv';


        $includeCourse =
            $this->selectedColumns($request)['course'];


        return response()->streamDownload(
            function () use ($request, $includeCourse) {

                $handle =
                    fopen('php://output', 'w');


                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM for Excel compatibility
                |--------------------------------------------------------------------------
                */
                fwrite(
                    $handle,
                    "\xEF\xBB\xBF"
                );


                $headers = [
                    'ID',
                    'Date & Time',
                    'Device',
                    'Event',
                    'Result',
                    'Reason',
                ];


                if ($includeCourse) {

                    array_splice(
                        $headers,
                        2,
                        0,
                        ['Course']
                    );

                }


                fputcsv(
                    $handle,
                    $headers
                );


                /*
                |--------------------------------------------------------------------------
                | Search and all filters are also applied to CSV.
                |--------------------------------------------------------------------------
                */
                $this->filteredLogsQuery($request)
                    ->orderBy(
                        'pc_access_logs.occurred_at',
                        'asc'
                    )
                    ->cursor()
                    ->each(
                        function ($log) use (
                            $handle,
                            $includeCourse
                        ) {

                            $row = [
                                $log->id,
                                $log->occurred_at,

                                // Corrected from $log->device
                                $log->workstation_name,

                                $log->event_type,
                                $log->result,
                                $log->reason,
                            ];


                            if ($includeCourse) {

                                array_splice(
                                    $row,
                                    2,
                                    0,
                                    [$log->course]
                                );

                            }


                            fputcsv(
                                $handle,
                                $row
                            );

                        }
                    );


                fclose($handle);

            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Export PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf(Request $request)
    {
        return $this
            ->reportPdf($request)
            ->download(
                $this->reportFilename()
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Preview PDF
    |--------------------------------------------------------------------------
    */
    public function previewPdf(Request $request)
    {
        $logs = $this->filteredLogsQuery($request)
            ->orderBy(
                'pc_access_logs.occurred_at',
                'asc'
            )
            ->get();


        return Pdf::view(
            'admin.reports.pdf',
            [
                'logs' => $logs,

                'columns' =>
                    $this->selectedColumns($request),

                'filters' =>
                    $request->only([
                        'search',
                        'date_from',
                        'date_to',
                        'course',
                        'device',
                        'event',
                        'result',
                        'reason',
                    ]),

                'generatedAt' =>
                    now(),
            ]
        )
            ->headerView(
                'admin.reports.header'
            )
            ->footerView(
                'admin.reports.footer'
            )
            ->margins(
                45,
                15,
                35,
                15,
                Unit::Millimeter
            )
            ->format(
                Format::A4
            )
            ->inline(
                'access-report-preview.pdf'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Build PDF
    |--------------------------------------------------------------------------
    */
    private function reportPdf(Request $request)
    {
        $logs = $this->filteredLogsQuery($request)
            ->orderBy(
                'pc_access_logs.occurred_at',
                'asc'
            )
            ->get();


        return Pdf::view(
            'admin.reports.pdf',
            [
                'logs' => $logs,

                'columns' =>
                    $this->selectedColumns($request),

                'filters' =>
                    $request->only([
                        'search',
                        'date_from',
                        'date_to',
                        'course',
                        'device',
                        'event',
                        'result',
                        'reason',
                    ]),

                'generatedAt' =>
                    now(),
            ]
        )
            ->headerView(
                'admin.reports.header'
            )
            ->footerView(
                'admin.reports.footer'
            )
            ->margins(
                45,
                15,
                35,
                15,
                Unit::Millimeter
            )
            ->format(
                Format::A4
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF Filename
    |--------------------------------------------------------------------------
    */
    private function reportFilename(): string
    {
        return
            'access-report-' .
            now()->format('Y-m-d_H-i-s') .
            '.pdf';
    }


    /*
    |--------------------------------------------------------------------------
    | Selected Columns
    |--------------------------------------------------------------------------
    */
    private function selectedColumns(
        Request $request
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Default columns
        |--------------------------------------------------------------------------
        */
        if (
            !$request->boolean(
                'columns_configured'
            )
        ) {

            return [
                'student_name' => true,
                'course' => true,
                'device' => true,
                'date_time' => true,
                'event' => true,
            ];

        }


        $requestedColumns =
            $request->input(
                'cols',
                []
            );


        return [
            'student_name' =>
                array_key_exists(
                    'student_name',
                    $requestedColumns
                ),

            'course' =>
                array_key_exists(
                    'course',
                    $requestedColumns
                ),

            'device' =>
                array_key_exists(
                    'device',
                    $requestedColumns
                ),

            'date_time' =>
                array_key_exists(
                    'date_time',
                    $requestedColumns
                ),

            'event' =>
                array_key_exists(
                    'event',
                    $requestedColumns
                ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Filtered Access Log Query
    |--------------------------------------------------------------------------
    */
    private function filteredLogsQuery(
        Request $request
    ) {

        $query = DB::table(
            'pc_access_logs'
        )
            ->select(
                'pc_access_logs.id',
                'pc_access_logs.occurred_at',

                'pc_access_logs.rfid_uid',
                'pc_access_logs.student_external_id',
                'pc_access_logs.student_name',
                'pc_access_logs.course',
                'pc_access_logs.session_id',

                'devices.device_uid',
                'devices.workstation_name',

                'pc_access_logs.event_type',
                'pc_access_logs.result',
                'pc_access_logs.reason'
            )
            ->join(
                'devices',
                'pc_access_logs.device_id',
                '=',
                'devices.id'
            );


        /*
        |--------------------------------------------------------------------------
        | SEARCH ACCESS LOGS
        |--------------------------------------------------------------------------
        |
        | The user can search using:
        |
        | - Student name
        | - Student external ID
        | - RFID UID
        | - Course
        | - Workstation name
        | - Device UID
        | - Session ID
        | - Event type
        | - Result
        | - Reason
        | - Numeric access log ID
        |
        */
        if ($request->filled('search')) {

            $search =
                trim(
                    (string) $request->input(
                        'search'
                    )
                );


            $like =
                '%' .
                $search .
                '%';


            $query->where(
                function ($searchQuery) use (
                    $search,
                    $like
                ) {

                    $searchQuery
                        ->where(
                            'pc_access_logs.student_name',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.student_external_id',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.rfid_uid',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.course',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'devices.workstation_name',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'devices.device_uid',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.session_id',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.event_type',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.result',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'pc_access_logs.reason',
                            'like',
                            $like
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Allow searching by access log ID
                    |--------------------------------------------------------------------------
                    */
                    if (ctype_digit($search)) {

                        $searchQuery->orWhere(
                            'pc_access_logs.id',
                            (int) $search
                        );

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_from')) {

            $query->whereDate(
                'pc_access_logs.occurred_at',
                '>=',
                $request->date_from
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_to')) {

            $query->whereDate(
                'pc_access_logs.occurred_at',
                '<=',
                $request->date_to
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Course
        |--------------------------------------------------------------------------
        */
        if ($request->filled('course')) {

            $query->where(
                'pc_access_logs.course',
                $request->course
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Workstation / Device
        |--------------------------------------------------------------------------
        |
        | Corrected:
        |
        | devices.w
        |
        | to:
        |
        | devices.workstation_name
        |
        */
        if ($request->filled('device')) {

            $query->where(
                'devices.workstation_name',
                $request->device
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        */
        if ($request->filled('event')) {

            $query->where(
                'pc_access_logs.event_type',
                $request->event
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Result
        |--------------------------------------------------------------------------
        */
        if ($request->filled('result')) {

            $query->where(
                'pc_access_logs.result',
                $request->result
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Reason
        |--------------------------------------------------------------------------
        */
        if ($request->filled('reason')) {

            $query->where(
                'pc_access_logs.reason',
                $request->reason
            );

        }


        return $query;
    }
}