<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class ReportsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ACCESS LOG REPORT
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Filter Options
        |--------------------------------------------------------------------------
        */

        $courses = PcAccessLogs::query()
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');


        $devices = Device::query()
            ->whereNotNull('workstation_name')
            ->where('workstation_name', '!=', '')
            ->distinct()
            ->orderBy('workstation_name')
            ->pluck('workstation_name');


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


        /*
        |--------------------------------------------------------------------------
        | Access Logs
        |--------------------------------------------------------------------------
        */

        $logs = $this
            ->filteredLogsQuery($request)
            ->orderBy(
                'pc_access_logs.occurred_at',
                'asc'
            )
            ->paginate(20)
            ->appends(
                $request->query()
            );


        $columns =
            $this->selectedColumns(
                $request
            );


        return view(
            'admin.reports.AccessLogReport.index',
            compact(
                'logs',
                'courses',
                'devices',
                'events',
                'results',
                'reasons',
                'columns'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESS LOG PDF DOWNLOAD
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
    | ACCESS LOG PDF PREVIEW
    |--------------------------------------------------------------------------
    */

    public function previewPdf(Request $request)
    {
        $logs = $this
            ->filteredLogsQuery(
                $request
            )
            ->orderBy(
                'pc_access_logs.occurred_at',
                'asc'
            )
            ->get();


        return Pdf::view(
            'admin.reports.AccessLogReport.pdf',
            [
                'logs' =>
                    $logs,

                'columns' =>
                    $this->selectedColumns(
                        $request
                    ),

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
                'admin.reports.AccessLogReport.header'
            )
            ->footerView(
                'admin.reports.AccessLogReport.footer'
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
    | BUILD ACCESS LOG PDF
    |--------------------------------------------------------------------------
    */

    private function reportPdf(
        Request $request
    ) {

        $logs = $this
            ->filteredLogsQuery(
                $request
            )
            ->orderBy(
                'pc_access_logs.occurred_at',
                'asc'
            )
            ->get();


        return Pdf::view(
            'admin.reports.AccessLogReport.pdf',
            [
                'logs' =>
                    $logs,

                'columns' =>
                    $this->selectedColumns(
                        $request
                    ),

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
                'admin.reports.AccessLogReport.header'
            )
            ->footerView(
                'admin.reports.AccessLogReport.footer'
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
    | ACCESS LOG PDF FILENAME
    |--------------------------------------------------------------------------
    */

    private function reportFilename(): string
    {
        return
            'access-report-' .
            now()->format(
                'Y-m-d_H-i-s'
            ) .
            '.pdf';
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESS LOG SELECTED COLUMNS
    |--------------------------------------------------------------------------
    */

    private function selectedColumns(
        Request $request
    ): array {

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
    | ACCESS LOG FILTER QUERY
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
                'pc_access_logs.reason',
                'pc_access_logs.ended_by',
                'pc_access_logs.ended_reason'
            )
            ->join(
                'devices',
                'pc_access_logs.device_id',
                '=',
                'devices.id'
            );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string)
                    $request->input(
                        'search'
                    )
                );


            $like =
                '%' .
                $search .
                '%';


            $query->where(
                function (
                    $searchQuery
                ) use (
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


                    if (
                        ctype_digit(
                            $search
                        )
                    ) {

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

        if (
            $request->filled(
                'date_from'
            )
        ) {

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

        if (
            $request->filled(
                'date_to'
            )
        ) {

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

        if (
            $request->filled(
                'course'
            )
        ) {

            $query->where(
                'pc_access_logs.course',
                $request->course
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Workstation
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'device'
            )
        ) {

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

        if (
            $request->filled(
                'event'
            )
        ) {

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

        if (
            $request->filled(
                'result'
            )
        ) {

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

        if (
            $request->filled(
                'reason'
            )
        ) {

            $query->where(
                'pc_access_logs.reason',
                $request->reason
            );
        }


        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    |--------------------------------------------------------------------------
    | STUDENT SUMMARY REPORT
    |--------------------------------------------------------------------------
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | SUMMARY REPORT PAGE
    |--------------------------------------------------------------------------
    */

    public function summaryReport(
        Request $request
    ) {

        $filters =
            $this->summaryFilters(
                $request
            );


        /*
        |--------------------------------------------------------------------------
        | Filter Options
        |--------------------------------------------------------------------------
        */

        $courses = PcAccessLogs::query()
            ->whereNotNull(
                'course'
            )
            ->where(
                'course',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy(
                'course'
            )
            ->pluck(
                'course'
            );


        $devices = Device::query()
            ->whereNotNull(
                'workstation_name'
            )
            ->where(
                'workstation_name',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy(
                'workstation_name'
            )
            ->pluck(
                'workstation_name'
            );


        /*
        |--------------------------------------------------------------------------
        | Student Summary
        |--------------------------------------------------------------------------
        |
        | One row = one student.
        |
        */

        $students = $this
            ->studentSummaryQuery(
                $filters
            )
            ->orderBy(
                'student_name'
            )
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Date Values
        |--------------------------------------------------------------------------
        */

        $dateFrom =
            $filters['date_from'];


        $dateTo =
            $filters['date_to'];


        $periodLabel =
            Carbon::parse(
                $dateFrom
            )->format(
                'M d, Y'
            )
            . ' – ' .
            Carbon::parse(
                $dateTo
            )->format(
                'M d, Y'
            );


        /*
        |--------------------------------------------------------------------------
        | Return Summary View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.reports.SummaryReport.index',
            compact(
                'students',
                'courses',
                'devices',
                'dateFrom',
                'dateTo',
                'periodLabel'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY PDF PREVIEW
    |--------------------------------------------------------------------------
    */

    public function summaryPreviewPdf(
        Request $request
    ) {

        $filters =
            $this->summaryFilters(
                $request
            );


        $students = $this
            ->studentSummaryQuery(
                $filters
            )
            ->orderBy(
                'student_name'
            )
            ->get();


        return $this
            ->summaryPdf(
                $students,
                $filters
            )
            ->inline(
                'student-summary-report-preview.pdf'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY PDF DOWNLOAD
    |--------------------------------------------------------------------------
    */

    public function summaryExportPdf(
        Request $request
    ) {

        $filters =
            $this->summaryFilters(
                $request
            );


        $students = $this
            ->studentSummaryQuery(
                $filters
            )
            ->orderBy(
                'student_name'
            )
            ->get();


        return $this
            ->summaryPdf(
                $students,
                $filters
            )
            ->download(
                $this->summaryReportFilename()
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD SUMMARY PDF
    |--------------------------------------------------------------------------
    */

    private function summaryPdf(
        $students,
        array $filters
    ) {

        $periodLabel =
            Carbon::parse(
                $filters['date_from']
            )->format(
                'M d, Y'
            )
            . ' – ' .
            Carbon::parse(
                $filters['date_to']
            )->format(
                'M d, Y'
            );


        return Pdf::view(
            'admin.reports.SummaryReport.pdf',
            [
                'students' =>
                    $students,

                'filters' =>
                    $filters,

                'periodLabel' =>
                    $periodLabel,

                'generatedAt' =>
                    now(),
            ]
        )
            /*
            |--------------------------------------------------------------------------
            | Separate Summary Report Header / Footer
            |--------------------------------------------------------------------------
            |
            | Create:
            |
            | admin/reports/SummaryReport/header.blade.php
            | admin/reports/SummaryReport/footer.blade.php
            |
            */

            ->headerView(
                'admin.reports.SummaryReport.header'
            )
            ->footerView(
                'admin.reports.SummaryReport.footer'
            )
            ->margins(
                45,
                12,
                35,
                12,
                Unit::Millimeter
            )
            ->format(
                Format::A4
            );
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT SUMMARY QUERY
    |--------------------------------------------------------------------------
    |
    | One row is returned for each student_external_id.
    |
    */

    private function studentSummaryQuery(
        array $filters
    ) {

        $startDate =
            Carbon::parse(
                $filters['date_from']
            )->startOfDay();


        $endDate =
            Carbon::parse(
                $filters['date_to']
            )->endOfDay();


        $query = DB::table(
            'pc_access_logs'
        )
            ->leftJoin(
                'devices',
                'pc_access_logs.device_id',
                '=',
                'devices.id'
            )

            /*
            |--------------------------------------------------------------------------
            | TIME IN records represent access attempts.
            |--------------------------------------------------------------------------
            */

            ->where(
                'pc_access_logs.event_type',
                'time_in'
            )

            ->whereBetween(
                'pc_access_logs.occurred_at',
                [
                    $startDate,
                    $endDate,
                ]
            )

            /*
            |--------------------------------------------------------------------------
            | Require a Student ID
            |--------------------------------------------------------------------------
            */

            ->whereNotNull(
                'pc_access_logs.student_external_id'
            )

            ->where(
                'pc_access_logs.student_external_id',
                '!=',
                ''
            )

            /*
            |--------------------------------------------------------------------------
            | Group Identifier
            |--------------------------------------------------------------------------
            */

            ->select(
                'pc_access_logs.student_external_id'
            )

            /*
            |--------------------------------------------------------------------------
            | Student Information
            |--------------------------------------------------------------------------
            */

            ->selectRaw(
                'MAX(pc_access_logs.student_name) AS student_name'
            )

            ->selectRaw(
                'MAX(pc_access_logs.course) AS course'
            )

            /*
            |--------------------------------------------------------------------------
            | Total Attempts
            |--------------------------------------------------------------------------
            */

            ->selectRaw(
                'COUNT(*) AS total_attempts'
            )

            /*
            |--------------------------------------------------------------------------
            | Allowed Attempts
            |--------------------------------------------------------------------------
            */

            ->selectRaw("
                SUM(
                    CASE
                        WHEN pc_access_logs.result = 'allowed'
                        THEN 1
                        ELSE 0
                    END
                ) AS allowed_accesses
            ")

            /*
            |--------------------------------------------------------------------------
            | Denied Attempts
            |--------------------------------------------------------------------------
            */

            ->selectRaw("
                SUM(
                    CASE
                        WHEN pc_access_logs.result = 'denied'
                        THEN 1
                        ELSE 0
                    END
                ) AS denied_accesses
            ")

            /*
            |--------------------------------------------------------------------------
            | Successful Sessions
            |--------------------------------------------------------------------------
            */

            ->selectRaw("
                COUNT(
                    DISTINCT CASE
                        WHEN pc_access_logs.result = 'allowed'
                        THEN pc_access_logs.session_id
                    END
                ) AS total_sessions
            ")

            /*
            |--------------------------------------------------------------------------
            | Number of Workstations Used
            |--------------------------------------------------------------------------
            */

            ->selectRaw(
                'COUNT(DISTINCT pc_access_logs.device_id) AS workstations_used'
            )

            /*
            |--------------------------------------------------------------------------
            | First Successful Access
            |--------------------------------------------------------------------------
            */

            ->selectRaw("
                MIN(
                    CASE
                        WHEN pc_access_logs.result = 'allowed'
                        THEN pc_access_logs.occurred_at
                    END
                ) AS first_access
            ")

            /*
            |--------------------------------------------------------------------------
            | Last Successful Access
            |--------------------------------------------------------------------------
            */

            ->selectRaw("
                MAX(
                    CASE
                        WHEN pc_access_logs.result = 'allowed'
                        THEN pc_access_logs.occurred_at
                    END
                ) AS last_access
            ");


        /*
        |--------------------------------------------------------------------------
        | Course Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['course']
            )
        ) {

            $query->where(
                'pc_access_logs.course',
                $filters['course']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Workstation Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['device']
            )
        ) {

            $query->where(
                'devices.workstation_name',
                $filters['device']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Group By Student
        |--------------------------------------------------------------------------
        */

        return $query
            ->groupBy(
                'pc_access_logs.student_external_id'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY FILTERS
    |--------------------------------------------------------------------------
    */

    private function summaryFilters(
        Request $request
    ): array {

        $validated =
            $request->validate([
                'date_from' => [
                    'nullable',
                    'date',
                ],

                'date_to' => [
                    'nullable',
                    'date',
                ],

                'course' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'device' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | Default Date Range
        |--------------------------------------------------------------------------
        |
        | Current month.
        |
        */

        $dateFrom =
            $validated['date_from']
            ?? now()
                ->startOfMonth()
                ->toDateString();


        $dateTo =
            $validated['date_to']
            ?? now()
                ->endOfMonth()
                ->toDateString();


        /*
        |--------------------------------------------------------------------------
        | Protect against invalid reversed ranges.
        |--------------------------------------------------------------------------
        */

        if (
            Carbon::parse($dateTo)
                ->lt(
                    Carbon::parse(
                        $dateFrom
                    )
                )
        ) {

            $dateTo =
                $dateFrom;
        }


        return [

            'date_from' =>
                $dateFrom,

            'date_to' =>
                $dateTo,

            'course' =>
                $validated['course']
                ?? null,

            'device' =>
                $validated['device']
                ?? null,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY PDF FILENAME
    |--------------------------------------------------------------------------
    */

    private function summaryReportFilename(): string
    {
        return
            'student-summary-report-' .
            now()->format(
                'Y-m-d_H-i-s'
            ) .
            '.pdf';
    }
}
