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
        $rangeLabels = [
            'today' => 'Today',
            'last_7_days' => 'Last 7 days',
            'last_30_days' => 'Last 30 days',
            'last_90_days' => 'Last 90 days',
            'last_Year' => 'Last Year',
            'all_time' => 'All Time',
        ];
        $ALLOWEDRanges = array_keys($rangeLabels);

        $studentRange = $request->query('students_range', 'today');
        $courseRange = $request->query('courses_range', 'today');
        $peakRange = $request->query('peak_range', 'today');

        $studentRange = in_array($studentRange, $ALLOWEDRanges, true) ? $studentRange : 'today';
        $courseRange = in_array($courseRange, $ALLOWEDRanges, true) ? $courseRange : 'today';
        $peakRange = in_array($peakRange, $ALLOWEDRanges, true) ? $peakRange : 'today';

        $now = now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();

        $rangeStart = function (string $range) use ($now): Carbon {
            return match ($range) {
                'today' => $now->copy()->startOfDay(),
                'last_7_days' => $now->copy()->subDays(6)->startOfDay(),
                'last_30_days' => $now->copy()->subDays(29)->startOfDay(),
                'last_90_days' => $now->copy()->subDays(89)->startOfDay(),
                'last_Year' => $now->copy()->subYear()->startOfDay(),
                'all_time' => Carbon::create(1970, 1, 1)->startOfDay(),
                default => $now->copy()->startOfDay(),
            };
        };
        $rangeEnd = fn (string $range): Carbon => $now->copy()->endOfDay();

        //Card data
        $popularWorkstation = PcAccessLogs::select('device_id', PcAccessLogs::raw('COUNT(*) as total'))
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->with('device')
            ->groupBy('device_id')
            ->orderBy('total', 'desc')
            ->take(1)
            ->get();
        $topApplication = PcAppUsage::select('app_name', PcAppUsage::raw('COUNT(*) as total'))
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->groupBy('app_name')
            ->orderBy('total', 'desc')
            ->take(1)
            ->get();
        $failedEvents = PcAccessLogs::whereIn('result', ['denied', 'fail'])
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->count();
        $successfulEvents = PcAccessLogs::where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->count();

        //line chart - only count time_in, not time_out
        $peakHoursByHour = PcAccessLogs::query()
            ->selectRaw('HOUR(occurred_at) as hour, COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$rangeStart($peakRange), $rangeEnd($peakRange)])
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
        $topStudents = PcAccessLogs::query()
            ->select('student_name')
            ->selectRaw('COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$rangeStart($studentRange), $rangeEnd($studentRange)])
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('student_name')
            ->where('student_name', '<>', '')
            ->whereNotNull('session_id')
            ->groupBy('student_name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get()
            ->map(function ($student) use ($studentRange, $rangeStart, $rangeEnd) {
                $sessionIds = PcAccessLogs::where('student_name', $student->student_name)
                    ->where('event_type', 'time_in')
                    ->where('result', 'allowed')
                    ->whereBetween('occurred_at', [$rangeStart($studentRange), $rangeEnd($studentRange)])
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

        $topCourses = PcAccessLogs::query()
            ->select('course')
            ->selectRaw('COUNT(DISTINCT session_id) as total')
            ->whereBetween('occurred_at', [$rangeStart($courseRange), $rangeEnd($courseRange)])
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('course')
            ->where('course', '<>', '')
            ->whereNotNull('session_id')
            ->groupBy('course')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get()
            ->map(function ($course) use ($courseRange, $rangeStart, $rangeEnd) {
                $sessionIds = PcAccessLogs::where('course', $course->course)
                    ->where('event_type', 'time_in')
                    ->where('result', 'allowed')
                    ->whereBetween('occurred_at', [$rangeStart($courseRange), $rangeEnd($courseRange)])
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

        $studentRangeLabel = $rangeLabels[$studentRange];
        $courseRangeLabel = $rangeLabels[$courseRange];
        $peakRangeLabel = $rangeLabels[$peakRange];


        return view('admin.analytics.index', compact(
            'failedEvents', 'popularWorkstation', 'successfulEvents', 'topApplication',
            'topStudents', 'topCourses', 'rangeLabels',
            'studentRange', 'courseRange',
            'studentRangeLabel', 'courseRangeLabel',
            'peakHours', 'peakRange', 'peakRangeLabel'
            ));
    }
}
