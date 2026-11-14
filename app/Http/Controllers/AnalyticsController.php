<?php

namespace App\Http\Controllers;
use App\Models\PcAccessLogs;
use App\Models\Device;
use App\Models\PcAppUsage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request){
        $now = now();
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);
        $dateFrom = Carbon::parse($validated['date_from'] ?? $now->toDateString())->startOfDay();
        $dateTo = Carbon::parse($validated['date_to'] ?? $now->toDateString())->endOfDay();

        //Card data
        $popularWorkstation = PcAccessLogs::select('device_id', PcAccessLogs::raw('COUNT(*) as total'))
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->with('device')
            ->groupBy('device_id')
            ->orderBy('total', 'desc')
            ->get(1);
        $popularApplication = PcAppUsage::select('app_name', PcAppUsage::raw('COUNT(*) as total'))
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->groupBy('app_name')
            ->orderBy('total', 'desc')
            ->get(1);
        $failedLogins = PcAccessLogs::whereIn('result', ['denied', 'fail'])
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->count();
        $successfulLogins = PcAccessLogs::where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->whereNotNull('student_name')
            ->where('student_name', '<>', '')
            ->distinct()
            ->count('student_name');

        //line chart - only count time_in, not time_out
        $peakHoursByHour = PcAccessLogs::query()
            ->selectRaw('HOUR(occurred_at) as hour, COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('student_name')
            ->where('student_name', '<>', '')
            ->whereNotNull('session_id')
            ->groupByRaw('HOUR(occurred_at)')
            ->orderBy('hour')
            ->pluck('total', 'hour');

        $peakHours = collect(range(0, 23))->map(function (int $hour) use ($peakHoursByHour): int {
            return (int) ($peakHoursByHour->get($hour, 0));
        })->values();

        //table data - count distinct sessions, add total time
        $topAccessStudents = PcAccessLogs::query()
            ->select('student_name')
            ->selectRaw('COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('student_name')
            ->where('student_name', '<>', '')
            ->whereNotNull('session_id')
            ->groupBy('student_name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get()
            ->map(function ($student) use ($dateFrom, $dateTo) {
                $sessionIds = PcAccessLogs::where('student_name', $student->student_name)
                    ->where('event_type', 'time_in')
                    ->where('result', 'allowed')
                    ->whereBetween('occurred_at', [$dateFrom, $dateTo])
                    ->whereNotNull('session_id')
                    ->pluck('session_id')
                    ->unique();

                $totalSeconds = 0;
                foreach ($sessionIds as $sid) {
                    $in = PcAccessLogs::where('session_id', $sid)->where('event_type', 'time_in')->where('result', 'allowed')->orderBy('occurred_at')->first();
                    $out = PcAccessLogs::where('session_id', $sid)->where('event_type', 'time_out')->orderBy('occurred_at')->first();
                    if ($in && $out && $out->occurred_at >= $in->occurred_at) {
                        $totalSeconds += $in->occurred_at->diffInSeconds($out->occurred_at);
                    }
                }
                $h = intdiv($totalSeconds, 3600);
                $m = intdiv($totalSeconds % 3600, 60);
                $s = $totalSeconds % 60;
                $student->total_time = "{$h}h {$m}m {$s}s";
                $student->total_seconds = $totalSeconds;
                return $student;
            });

        $topUsageStudents = PcAccessLogs::query()
            ->select('student_name')
            ->selectRaw('SUM(TIMESTAMPDIFF(SECOND, in_time, out_time)) as total_seconds')
            ->fromSub(function ($query) use ($dateFrom, $dateTo) {
                $query->from('pc_access_logs')
                    ->select('student_name', 'session_id')
                    ->selectRaw("MIN(CASE WHEN event_type = 'time_in' THEN occurred_at END) as in_time")
                    ->selectRaw("MAX(CASE WHEN event_type = 'time_out' THEN occurred_at END) as out_time")
                    ->whereBetween('occurred_at', [$dateFrom, $dateTo])
                    ->where('result', 'allowed')
                    ->whereNotNull('student_name')
                    ->where('student_name', '<>', '')
                    ->whereNotNull('session_id')
                    ->groupBy('session_id', 'student_name');
            }, 'sessions_summary')
            ->groupBy('student_name')
            ->orderByDesc('total_seconds')
            ->take(10)
            ->get()
            ->map(function ($student) {
                $totalSeconds = (int) ($student->total_seconds ?? 0);

                $h = intdiv($totalSeconds, 3600);
                $m = intdiv($totalSeconds % 3600, 60);
                $s = $totalSeconds % 60;

                $student->total_time = "{$h}h {$m}m {$s}s";
                return $student;
            });

        $topCourses = PcAccessLogs::query()
            ->select('course')
            ->selectRaw('COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('course')
            ->where('course', '<>', '')
            ->whereNotNull('session_id')
            ->groupBy('course')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get()
            ->map(function ($course) use ($dateFrom, $dateTo) {
                $sessionIds = PcAccessLogs::where('course', $course->course)
                    ->where('event_type', 'time_in')
                    ->where('result', 'allowed')
                    ->whereBetween('occurred_at', [$dateFrom, $dateTo])
                    ->whereNotNull('session_id')
                    ->pluck('session_id')
                    ->unique();

                $totalSeconds = 0;
                foreach ($sessionIds as $sid) {
                    $in = PcAccessLogs::where('session_id', $sid)->where('event_type', 'time_in')->where('result', 'allowed')->orderBy('occurred_at')->first();
                    $out = PcAccessLogs::where('session_id', $sid)->where('event_type', 'time_out')->orderBy('occurred_at')->first();
                    if ($in && $out && $out->occurred_at >= $in->occurred_at) {
                        $totalSeconds += $in->occurred_at->diffInSeconds($out->occurred_at);
                    }
                }
                $h = intdiv($totalSeconds, 3600);
                $m = intdiv($totalSeconds % 3600, 60);
                $s = $totalSeconds % 60;
                $course->total_time = "{$h}h {$m}m {$s}s";
                $course->total_seconds = $totalSeconds;
                return $course;
            });

        $topApplication = PcAppUsage::query()
            ->select('app_name')
            ->selectRaw('COUNT(DISTINCT session_id) as total_sessions')
            ->selectRaw('SUM(seconds) as total_seconds')
            ->whereBetween('occurred_at', [$dateFrom, $dateTo])
            ->whereNotNull('app_name')
            ->where('app_name', '<>', '')
            ->groupBy('app_name')
            ->orderByDesc('total_sessions')
            ->take(10)
            ->get()
            ->map(function ($app) {
                $totalSeconds = (int) ($app->total_seconds ?? 0);

                $h = intdiv($totalSeconds, 3600);
                $m = intdiv($totalSeconds % 3600, 60);
                $s = $totalSeconds % 60;

                $app->total_time = "{$h}h {$m}m {$s}s";
                return $app;
            });

        return view('admin.analytics.index', compact(
            'failedLogins', 'popularWorkstation', 'successfulLogins', 'popularApplication',
            'topAccessStudents', 'topCourses', 'topApplication', 'peakHours', 'topUsageStudents',
            'dateFrom', 'dateTo'
            ));
    }
}
