<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\PcAppUsage;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Device stats
        $totalDevices = Device::count();
        $activeDevices = Device::where('is_active', 1)->count();
        $onlineDevices = Device::where('last_seen_at', '>=', Carbon::now()->subMinutes(5))->count();
        $totalLoginsToday= PcAccessLogs::whereDate('occurred_at', Carbon::today())->count('student_external_id');
        $weekStart = Carbon::today()->startOfWeek(Carbon::MONDAY);
        $uniqueStudentsToday = PcAccessLogs::whereDate('occurred_at', Carbon::today())
            ->distinct('student_external_id')
            ->count('student_external_id');
        // Weekly Visitors (unique student sessions from Monday through Sunday)
        $weeklyVisitors = PcAccessLogs::where('occurred_at', '>=', $weekStart)
            ->distinct('student_external_id')->count('student_external_id');
        $avgSessionDuration = PcAccessLogs::query()
        ->from('pc_access_logs as login')
        ->join('pc_access_logs as logout', 'login.session_id', '=', 'logout.session_id')
        ->where('login.event_type', 'login')   
        ->where('logout.event_type', 'logout') 
        ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, login.occurred_at, logout.occurred_at)) as duration')
        ->value('duration');

        if (!$avgSessionDuration) {
            $avgSessionDuration = '0h 0m';
        } else {
            $interval = CarbonInterval::seconds((int) $avgSessionDuration)->cascade();

            $formatted = [];
            if ($interval->hours > 0) {
                $formatted[] = $interval->hours . 'h';
            }
            if ($interval->minutes > 0 || empty($formatted)) {
                $formatted[] = $interval->minutes . 'm';
            }

            $avgSessionDuration = implode(' ', $formatted);
        }

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
            'avgSessionDuration', 'courseDistribution', 'totalStudents', 'totalLoginsToday','uniqueStudentsToday'
        ));
    }

    
}
