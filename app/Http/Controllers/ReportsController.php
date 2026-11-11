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
        $tab = $request->query('tab') === 'students'
            ? 'students'
            : 'access';

        $resolved = $this->applyResolvedPeriod($request);

        $step = (int) $request->query('step', 0);

        if ($step < 1 || $step > 4) {
            /*
            | Legacy links that already point at a specific report
            | should land on the review step instead of starting over.
            */
            $step = $request->has('tab') ? 4 : 1;
        }

        $data = [
            'step' => $step,
            'tab' => $tab,
            'period' => $resolved['period'],
            'isAllTime' => $resolved['all_time'],
            'dateFrom' => $resolved['date_from'],
            'dateTo' => $resolved['date_to'],
            'reportTitle' => $tab === 'students'
                ? 'Student totals'
                : 'Activity records',
        ];

        if ($step === 3) {
            $data = array_merge(
                $data,
                $this->filterOptions()
            );

            $data['columns'] = $this->selectedColumns($request);
        }

        if ($step === 4) {

            if ($tab === 'students') {

                $filters = $this->summaryFilters($request);

                $data['students'] = $this
                    ->studentSummaryQuery($filters)
                    ->orderBy('student_name')
                    ->paginate(20)
                    ->withQueryString();

                $data['dateFrom'] = $filters['date_from'];
                $data['dateTo'] = $filters['date_to'];
                $data['isAllTime'] = $filters['all_time'];

                $analytics = $this->studentSummaryAnalytics($filters);
                $data = array_merge($data, $analytics);

            } else {

                $data['logs'] = $this
                    ->filteredLogsQuery($request)
                    ->orderBy(
                        'pc_access_logs.occurred_at',
                        'asc'
                    )
                    ->paginate(20)
                    ->withQueryString();

                $data['columns'] = $this->selectedColumns($request);
            }
        }

        return view(
            'admin.reports.index',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REPORT PERIOD
    |--------------------------------------------------------------------------
    */

    private function resolvePeriod(Request $request): array
    {
        $period = $request->input('period');

        if (!$period) {

            if ($request->input('range') === 'all') {

                $period = 'all';

            } else {

                $today = now()->toDateString();
                $monthStart = now()->startOfMonth()->toDateString();
                $weekStart = now()->subDays(6)->toDateString();

                $dateFrom = $request->filled('date_from')
                    ? $request->date_from
                    : $monthStart;

                $dateTo = $request->filled('date_to')
                    ? $request->date_to
                    : $today;

                if ($dateFrom === $today && $dateTo === $today) {
                    $period = 'today';
                } elseif ($dateFrom === $weekStart && $dateTo === $today) {
                    $period = 'week';
                } elseif (
                    $dateFrom === $monthStart
                    && in_array($dateTo, [$today, now()->endOfMonth()->toDateString()], true)
                ) {
                    $period = 'month';
                } else {
                    $period = 'custom';
                }
            }
        }

        if ($period === 'all') {
            return [
                'period' => 'all',
                'all_time' => true,
                'date_from' => null,
                'date_to' => null,
            ];
        }

        $today = now()->toDateString();

        switch ($period) {

            case 'today':
                $dateFrom = $today;
                $dateTo = $today;
                break;

            case 'week':
                $dateFrom = now()->subDays(6)->toDateString();
                $dateTo = $today;
                break;

            case 'custom':
                $dateFrom = $request->filled('date_from')
                    ? $request->date_from
                    : now()->startOfMonth()->toDateString();

                $dateTo = $request->filled('date_to')
                    ? $request->date_to
                    : $today;
                break;

            case 'month':
            default:
                $period = 'month';
                $dateFrom = now()->startOfMonth()->toDateString();
                $dateTo = $today;
                break;
        }

        try {

            if (Carbon::parse($dateTo)->lt(Carbon::parse($dateFrom))) {
                $dateTo = $dateFrom;
            }

        } catch (\Throwable $e) {

            $dateFrom = now()->startOfMonth()->toDateString();
            $dateTo = now()->toDateString();
        }

        return [
            'period' => $period,
            'all_time' => false,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];
    }


    private function applyResolvedPeriod(Request $request): array
    {
        $resolved = $this->resolvePeriod($request);

        $request->merge([
            'period' => $resolved['period'],
            'range' => $resolved['all_time'] ? 'all' : null,
            'date_from' => $resolved['date_from'],
            'date_to' => $resolved['date_to'],
        ]);

        return $resolved;
    }


    private function filterOptions(): array
    {
        return [
            'courses' => PcAccessLogs::query()
                ->whereNotNull('course')
                ->where('course', '!=', '')
                ->distinct()
                ->orderBy('course')
                ->pluck('course'),

            'devices' => Device::query()
                ->whereNotNull('workstation_name')
                ->where('workstation_name', '!=', '')
                ->distinct()
                ->orderBy('workstation_name')
                ->pluck('workstation_name'),

            'events' => PcAccessLogs::query()
                ->whereNotNull('event_type')
                ->where('event_type', '!=', '')
                ->distinct()
                ->orderBy('event_type')
                ->pluck('event_type'),

            'results' => PcAccessLogs::query()
                ->whereNotNull('result')
                ->where('result', '!=', '')
                ->distinct()
                ->orderBy('result')
                ->pluck('result'),

            'reasons' => PcAccessLogs::query()
                ->whereNotNull('reason')
                ->where('reason', '!=', '')
                ->distinct()
                ->orderBy('reason')
                ->pluck('reason'),
        ];
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

        $this->applyResolvedPeriod($request);

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
        | Date Range
        |--------------------------------------------------------------------------
        */

        if ($request->input('range') !== 'all') {

            $dateFrom = $request->filled('date_from')
                ? $request->date_from
                : now()->startOfMonth()->toDateString();

            $dateTo = $request->filled('date_to')
                ? $request->date_to
                : now()->toDateString();


            $query->whereDate(
                'pc_access_logs.occurred_at',
                '>=',
                $dateFrom
            );


            $query->whereDate(
                'pc_access_logs.occurred_at',
                '<=',
                $dateTo
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


        $analytics = $this->studentSummaryAnalytics($filters, $students);

        return Pdf::view(
            'admin.reports.SummaryReport.pdf',
            array_merge([
                'students' =>
                    $students,

                'filters' =>
                    $filters,

                'periodLabel' =>
                    $periodLabel,

                'generatedAt' =>
                    now(),
            ], $analytics)
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

        $query = DB::table('pc_access_logs')
            ->leftJoin(
                'devices',
                'pc_access_logs.device_id',
                '=',
                'devices.id'
            )
            ->where(
                'pc_access_logs.event_type',
                'time_in'
            );

        if (!($filters['all_time'] ?? false)) {

            $query->whereBetween(
                'pc_access_logs.occurred_at',
                [
                    Carbon::parse($filters['date_from'])->startOfDay(),
                    Carbon::parse($filters['date_to'])->endOfDay(),
                ]
            );
        }

        $query

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
    | STUDENT SUMMARY ANALYTICS
    |--------------------------------------------------------------------------
    |
    | Computes overall course distribution and top 3 rankings for:
    | - Students by logins (allowed check-ins)
    | - Students by accumulated usage time
    | - Courses by logins
    | - Courses by accumulated usage time
    |
    */
    private function studentSummaryAnalytics(array $filters, $summaryStudents = null): array
    {
        if ($summaryStudents === null) {
            $summaryStudents = $this->studentSummaryQuery($filters)->get();
        }

        $totalCourseStudents = $summaryStudents->count();

        // 1. Overall Course Distribution based on the distinct students in this report
        $courseDistribution = $summaryStudents
            ->groupBy(function ($s) {
                return $s->course ?: 'Unassigned';
            })
            ->map(function ($group, $courseName) {
                return (object) [
                    'course' => $courseName,
                    'student_count' => $group->count(),
                    'login_count' => (int) $group->sum('allowed_accesses'),
                ];
            })
            ->sortByDesc('student_count')
            ->values();

        // Prepare slices for donut chart (Top 5 + "Other courses" if more)
        $chartCourseLabels = [];
        $chartCourseCounts = [];
        $chartCoursePercentages = [];
        $chartCourseColors = [
            '#1D4ED8', '#2563EB', '#3B82F6', '#60A5FA', '#93C5FD', '#CBD5E1'
        ];

        if ($totalCourseStudents > 0) {
            $topSlices = $courseDistribution->take(5);
            $othersCount = (int) $courseDistribution->skip(5)->sum('student_count');

            foreach ($topSlices as $slice) {
                $chartCourseLabels[] = $slice->course;
                $chartCourseCounts[] = (int) $slice->student_count;
            }

            if ($othersCount > 0) {
                $chartCourseLabels[] = 'Other courses';
                $chartCourseCounts[] = $othersCount;
            }

            foreach ($chartCourseCounts as $count) {
                $chartCoursePercentages[] = round(($count / $totalCourseStudents) * 100, 1);
            }
        }

        // 2. Top 3 Students by Logins (from the distinct student records)
        $topStudentsByLogins = $summaryStudents
            ->sortByDesc('allowed_accesses')
            ->take(3)
            ->map(function ($s) {
                return (object) [
                    'student_external_id' => $s->student_external_id,
                    'student_name' => $s->student_name,
                    'course' => $s->course,
                    'login_count' => (int) $s->allowed_accesses,
                ];
            })
            ->values();

        // 3. Top 3 Courses by Logins
        $topCoursesByLogins = $courseDistribution
            ->sortByDesc('login_count')
            ->take(3)
            ->values();

        // 4 & 5. Session Usage Times
        $sessionDurations = DB::table('pc_access_logs as in_log')
            ->leftJoin('devices', 'in_log.device_id', '=', 'devices.id')
            ->join('pc_access_logs as out_log', function ($join) {
                $join->on('in_log.session_id', '=', 'out_log.session_id')
                    ->where('out_log.event_type', '=', 'time_out');
            })
            ->where('in_log.event_type', 'time_in')
            ->where('in_log.result', 'allowed')
            ->whereNotNull('in_log.session_id')
            ->select(
                'in_log.session_id',
                'in_log.student_external_id',
                'in_log.student_name',
                'in_log.course',
                'devices.workstation_name',
                'in_log.occurred_at as time_in_at',
                'out_log.occurred_at as time_out_at',
                DB::raw('TIMESTAMPDIFF(SECOND, in_log.occurred_at, out_log.occurred_at) as duration_seconds')
            );

        if (!($filters['all_time'] ?? false)) {
            $sessionDurations->whereBetween('in_log.occurred_at', [
                Carbon::parse($filters['date_from'])->startOfDay(),
                Carbon::parse($filters['date_to'])->endOfDay(),
            ]);
        }

        if (!empty($filters['course'])) {
            $sessionDurations->where('in_log.course', $filters['course']);
        }

        if (!empty($filters['device'])) {
            $sessionDurations->where('devices.workstation_name', $filters['device']);
        }

        // Top 3 Students by Accumulated Usage Time
        $topStudentsByTime = DB::query()
            ->fromSub($sessionDurations, 'sessions')
            ->whereNotNull('student_external_id')
            ->where('student_external_id', '!=', '')
            ->where('duration_seconds', '>=', 0)
            ->select('student_external_id')
            ->selectRaw('MAX(student_name) as student_name, MAX(course) as course, SUM(duration_seconds) as total_seconds, COUNT(*) as session_count')
            ->groupBy('student_external_id')
            ->orderByDesc('total_seconds')
            ->limit(3)
            ->get()
            ->map(function ($s) {
                $s->formatted_time = $this->formatDurationSeconds((int) $s->total_seconds);
                return $s;
            });

        // Top 3 Courses by Accumulated Usage Time
        $topCoursesByTime = DB::query()
            ->fromSub($sessionDurations, 'sessions')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->where('duration_seconds', '>=', 0)
            ->select('course')
            ->selectRaw('SUM(duration_seconds) as total_seconds, COUNT(*) as session_count')
            ->groupBy('course')
            ->orderByDesc('total_seconds')
            ->limit(3)
            ->get()
            ->map(function ($c) {
                $c->formatted_time = $this->formatDurationSeconds((int) $c->total_seconds);
                return $c;
            });

        return [
            'courseDistribution'     => $courseDistribution,
            'chartCourseLabels'      => $chartCourseLabels,
            'chartCourseCounts'      => $chartCourseCounts,
            'chartCoursePercentages' => $chartCoursePercentages,
            'chartCourseColors'      => $chartCourseColors,
            'totalCourseStudents'    => $totalCourseStudents,
            'topStudentsByLogins'    => $topStudentsByLogins,
            'topStudentsByTime'      => $topStudentsByTime,
            'topCoursesByLogins'     => $topCoursesByLogins,
            'topCoursesByTime'       => $topCoursesByTime,
        ];
    }

    private function formatDurationSeconds(int $seconds): string
    {
        $seconds = max(0, $seconds);
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m" . ($secs > 0 ? " {$secs}s" : '');
        }

        if ($minutes > 0) {
            return "{$minutes}m {$secs}s";
        }

        return "{$secs}s";
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY FILTERS
    |--------------------------------------------------------------------------
    */

    private function summaryFilters(
        Request $request
    ): array {

        $this->applyResolvedPeriod($request);

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
        | Optional Date Range
        |--------------------------------------------------------------------------
        |
        | Defaults to the current month. “All time” skips the range entirely.
        |
        */

        $allTime = $request->input('range') === 'all';

        $dateFrom = $allTime
            ? null
            : (($validated['date_from'] ?? null) ?: now()->startOfMonth()->toDateString());

        $dateTo = $allTime
            ? null
            : (($validated['date_to'] ?? null) ?: now()->toDateString());


        if (
            !$allTime
            && Carbon::parse($dateTo)
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

            'all_time' =>
                $allTime,
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
