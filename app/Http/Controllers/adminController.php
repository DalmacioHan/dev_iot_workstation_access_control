<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\PcAppUsage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Device stats
        $totalDevices = Device::count();
        $activeDevices = Device::where('is_active', 1)->count();
        $onlineDevices = Device::where('last_seen_at', '>=', now()->subMinutes(5))->count();

        $weekStart = Carbon::today()->startOfWeek(Carbon::MONDAY);

        // Weekly Visitors (unique student sessions from Monday through Sunday)
        $weeklyVisitors = PcAccessLogs::where('occurred_at', '>=', $weekStart)
            ->distinct('student_external_id')->count('student_external_id');


        $male = [];
        $female = [];
        $columnChartDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $columnChartDays[] = $date->format('l');

            $male[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%1')
                ->distinct('student_external_id')
                ->count('student_external_id');

            $female[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%2')
                ->distinct('student_external_id')
                ->count('student_external_id');
        }


        $courseDistribution = PcAccessLogs::selectRaw('course, COUNT(*) as count')
            ->groupBy('course')
            ->pluck('count', 'course')
            ->toArray();

        $totalStudents = PcAccessLogs::distinct('student_external_id')->count('student_external_id');

        return view('admin.dashboard', compact(
            'totalDevices', 'activeDevices', 'onlineDevices',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'courseDistribution', 'totalStudents'
        ));
    }

    public function analytics()
    {
        $activeDevices     = Device::where('is_active', 1)->count();
        $onlineDevices     = Device::where('last_seen_at', '>=', now()->subMinutes(5))->count();
        $totalAccessEvents = PcAccessLogs::count();
        $failedAttempts    = PcAccessLogs::where('result', 'denied')->count();

        // Device with the most access events.
        $popularDevice = PcAccessLogs::selectRaw('device_id, COUNT(*) as events')
            ->groupBy('device_id')
            ->orderByDesc('events')
            ->first();
        $popularDevice = $popularDevice ? Device::find($popularDevice->device_id) : null;

        // Course distribution (pie chart).
        $sortedCourses = collect(PcAccessLogs::selectRaw('course, COUNT(*) as count')
            ->whereNotNull('course')
            ->groupBy('course')
            ->pluck('count', 'course'))
            ->sortDesc();
        $courseLabels = $sortedCourses->keys()->values()->all();
        $courseCounts = $sortedCourses->values()->all();
        if (count($courseLabels) === 0) {
            $courseLabels = ['No data'];
            $courseCounts = [1];
        }

        // Daily male/female visitor proxy for the column chart (last 7 days).
        $male = [];
        $female = [];
        $columnChartDays = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $columnChartDays[] = $date->format('D');

            $male[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%1')
                ->distinct('student_external_id')
                ->count('student_external_id');

            $female[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('student_external_id', 'like', '%2')
                ->distinct('student_external_id')
                ->count('student_external_id');
        }

        // Most used applications (sum of tracked foreground seconds).
        $topApps = PcAppUsage::selectRaw('app_name, SUM(seconds) as total_seconds')
            ->groupBy('app_name')
            ->orderByDesc('total_seconds')
            ->limit(8)
            ->get();

        // Top students by active usage time (usage joined to the time_in row).
        $topStudents = PcAppUsage::leftJoin('pc_access_logs as log', function ($join) {
                $join->on('log.session_id', '=', 'pc_app_usage.session_id')
                    ->where('log.event_type', 'time_in');
            })
            ->selectRaw('COALESCE(NULLIF(log.student_name, ""), "Unknown") as student_name')
            ->selectRaw('SUM(pc_app_usage.seconds) as total_seconds')
            ->selectRaw('COUNT(DISTINCT pc_app_usage.session_id) as sessions')
            ->groupBy('log.student_name')
            ->orderByDesc('total_seconds')
            ->limit(8)
            ->get();

        return view('admin.analytics.index', compact(
            'activeDevices', 'onlineDevices', 'totalAccessEvents', 'failedAttempts',
            'popularDevice', 'courseLabels', 'courseCounts',
            'male', 'female', 'columnChartDays', 'topApps', 'topStudents'
        ));
    }

    public function reports(Request $request)
    {
        $courses      = PcAccessLogs::whereNotNull('course')->distinct()->orderBy('course')->pluck('course');
        $devices = Device::orderBy('name')->get(['id', 'name']);
        $events       = PcAccessLogs::distinct()->orderBy('event_type')->pluck('event_type');
        $reasons      = PcAccessLogs::whereNotNull('reason')->distinct()->orderBy('reason')->pluck('reason');

        $query = PcAccessLogs::with('device')->latest('occurred_at');

        if ($request->filled('date_from')) {
            $query->whereDate('occurred_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('occurred_at', '<=', $request->input('date_to'));
        }
        if ($request->filled('course')) {
            $query->where('course', $request->input('course'));
        }
        if ($request->filled('device')) {
            $query->where('device_id', $request->input('device'));
        }
        if ($request->filled('event')) {
            $query->where('event_type', $request->input('event'));
        }
        if ($request->filled('result')) {
            $query->where('result', $request->input('result'));
        }
        if ($request->filled('reason')) {
            $query->where('reason', $request->input('reason'));
        }

        $logs = $query->limit(500)->get();

        return view('admin.reports.index', compact('courses', 'devices', 'events', 'reasons', 'logs'));
    }
}
