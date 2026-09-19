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
        ];
        $allowedRanges = array_keys($rangeLabels);
        $studentRange = $request->query('students_range', 'today');
        $courseRange = $request->query('courses_range', 'today');

        $studentRange = in_array($studentRange, $allowedRanges, true) ? $studentRange : 'today';
        $courseRange = in_array($courseRange, $allowedRanges, true) ? $courseRange : 'today';

        $now = now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();

        $rangeStart = function (string $range) use ($now): Carbon {
            return match ($range) {
                'today' => $now->copy()->startOfDay(),
                'last_7_days' => $now->copy()->subDays(6)->startOfDay(),
                'last_30_days' => $now->copy()->subDays(29)->startOfDay(),
                'last_90_days' => $now->copy()->subDays(89)->startOfDay(),
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
        $failedEvents = PcAccessLogs::where('result', 'FAIL')
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->count();
        $successfulEvents = PcAccessLogs::where('result', 'SUCCESS')
            ->whereBetween('occurred_at', [$todayStart, $todayEnd])
            ->count();

        //table data
        $topStudents = PcAccessLogs::select('student_name', PcAccessLogs::raw('count(*) as total'))
            ->whereBetween('occurred_at', [$rangeStart($studentRange), $rangeEnd($studentRange)])
            ->groupBy('student_name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $topCourses = PcAccessLogs::select('course', PcAccessLogs::raw('count(*) as total'))
            ->whereBetween('occurred_at', [$rangeStart($courseRange), $rangeEnd($courseRange)])
            ->groupBy('course')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $studentRangeLabel = $rangeLabels[$studentRange];
        $courseRangeLabel = $rangeLabels[$courseRange];

        return view('admin.analytics.index', compact(
            'failedEvents', 'popularWorkstation', 'successfulEvents', 'topApplication',
            'topStudents', 'topCourses', 'rangeLabels',
            'studentRange', 'courseRange',
            'studentRangeLabel', 'courseRangeLabel'));
    }
}
