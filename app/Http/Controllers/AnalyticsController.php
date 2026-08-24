<?php

namespace App\Http\Controllers;

use App\Models\PcAccessLogs;
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

        $todayStart = now()->startOfDay();
        $rangeStart = function (string $range): Carbon {
            return match ($range) {
                'today' => now()->startOfDay(),
                'last_7_days' => now()->subDays(6)->startOfDay(),
                'last_30_days' => now()->subDays(29)->startOfDay(),
                'last_90_days' => now()->subDays(89)->startOfDay(),
                default => now()->startOfDay(),
            };
        };
        $rangeEnd = fn (string $range): Carbon => now();

        //Card data
        $popularWorkstation = PcAccessLogs::select('workstation_id', PcAccessLogs::raw('count(*) as total'))
            ->where('occurred_at', '>=', $todayStart)
            ->with('workstation')
            ->groupBy('workstation_id')
            ->orderBy('total', 'desc')
            ->first();
        $totalEvents = PcAccessLogs::where('occurred_at', '>=', $todayStart)->count();
        $failedEvents = PcAccessLogs::where('result', 'FAIL')->where('occurred_at', '>=', $todayStart)->count();

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
            'totalEvents', 'failedEvents', 'popularWorkstation',
            'topStudents', 'topCourses', 'rangeLabels',
            'studentRange', 'courseRange',
            'studentRangeLabel', 'courseRangeLabel'));
    }
}
