<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        
        $successResult = 'allowed';

        $now = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $tomorrow = $todayStart->copy()->addDay();
        $weekStart = $todayStart->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->addWeek();

        
        $successfulLogins = function () use ($successResult) {
            return PcAccessLogs::query()
                ->where('event_type', 'login')
                ->where('result', $successResult);
        };

        // Device stats
        $totalDevices = Device::count();
        $activeDevices = Device::where('is_active', 1)->count();
        $onlineDevices = Device::where('is_active', 1)
            ->where('last_seen_at', '>=', $now->copy()->subMinutes(5))
            ->count();

        // Today's successful login events (one student can log in multiple times)
        $totalLoginsToday = $successfulLogins()
            ->where('occurred_at', '>=', $todayStart)
            ->where('occurred_at', '<', $tomorrow)
            ->count();

        // Distinct students with successful logins today
        $uniqueStudentsToday = $successfulLogins()
            ->where('occurred_at', '>=', $todayStart)
            ->where('occurred_at', '<', $tomorrow)
            ->distinct()
            ->count('student_external_id');

        // Distinct students with successful logins this week (Mon–Sun)
        $weeklyVisitors = $successfulLogins()
            ->where('occurred_at', '>=', $weekStart)
            ->where('occurred_at', '<', $weekEnd)
            ->distinct()
            ->count('student_external_id');

        // One duration per completed session. Logout rows need not have result 'allowed'.
        $sessionTimes = PcAccessLogs::query()
            ->select('session_id')
            ->selectRaw(
                'MIN(CASE WHEN event_type = ? AND result = ? THEN occurred_at END) AS login_at',
                ['login', $successResult]
            )
            ->selectRaw(
                'MAX(CASE WHEN event_type = ? THEN occurred_at END) AS logout_at',
                ['logout']
            )
            ->whereNotNull('session_id')
            ->groupBy('session_id');

        $avgSeconds = DB::query()
            ->fromSub($sessionTimes, 'sessions')
            ->whereNotNull('login_at')
            ->whereNotNull('logout_at')
            ->whereColumn('logout_at', '>=', 'login_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, login_at, logout_at)) AS avg_seconds')
            ->value('avg_seconds');

        $durationSeconds = max(0, (int) round($avgSeconds ?? 0));
        $hours = intdiv($durationSeconds, 3600);
        $minutes = intdiv($durationSeconds % 3600, 60);
        $avgSessionDuration = "{$hours}h {$minutes}m";

        // Weekly unique students by gender (assumes ID suffix -1 = male, -2 = female)
        $male = [];
        $female = [];
        $columnChartDays = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $nextDate = $date->copy()->addDay();
            $columnChartDays[] = $date->format('l');

            $male[] = $successfulLogins()
                ->where('occurred_at', '>=', $date)
                ->where('occurred_at', '<', $nextDate)
                ->where('student_external_id', 'like', '%-1')
                ->distinct()
                ->count('student_external_id');

            $female[] = $successfulLogins()
                ->where('occurred_at', '>=', $date)
                ->where('occurred_at', '<', $nextDate)
                ->where('student_external_id', 'like', '%-2')
                ->distinct()
                ->count('student_external_id');
        }

        // All-time distribution of unique successful students, grouped by course
        $courseExpression = "COALESCE(NULLIF(TRIM(course), ''), 'Unspecified')";
        $courseDistribution = $successfulLogins()
            ->selectRaw("{$courseExpression} AS course_name, COUNT(DISTINCT student_external_id) AS student_count")
            ->groupByRaw($courseExpression)
            ->pluck('student_count', 'course_name')
            ->toArray();

        // All-time distinct students who have successfully logged in
        $totalStudents = $successfulLogins()
            ->distinct()
            ->count('student_external_id');

        return view('admin.dashboard', compact(
            'totalDevices', 'activeDevices', 'onlineDevices',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'avgSessionDuration', 'courseDistribution', 'totalStudents',
            'totalLoginsToday', 'uniqueStudentsToday'
        ));
    }
}
