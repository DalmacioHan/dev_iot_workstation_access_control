<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\Workstations;
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

        // Workstation stats
        $totalWorkstations = Workstations::count();
        $activeWorkstations = Workstations::where('is_active', 1)->count();

        
        $slotUtilization = $totalWorkstations > 0 ? round(($activeWorkstations / $totalWorkstations) * 100) : 0;

        // Weekly Visitors (unique student sessions in last 7 days)
        $weeklyVisitors = PcAccessLogs::where('occurred_at', '>=', now()->subDays(7))
            ->distinct('student_external_id')->count('student_external_id');

    
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

    
        $courseDistribution = PcAccessLogs::selectRaw('course, COUNT(*) as count')
            ->groupBy('course')
            ->pluck('count', 'course')
            ->toArray();

        $totalStudents = PcAccessLogs::distinct('student_external_id')->count('student_external_id');

        return view('admin.dashboard', compact(
            'totalDevices', 'activeDevices', 'onlineDevices',
            'totalWorkstations', 'activeWorkstations', 'slotUtilization',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'courseDistribution', 'totalStudents'
        ));
    }

    public function reports(){
        return view('admin.reports.index');
    }
}
