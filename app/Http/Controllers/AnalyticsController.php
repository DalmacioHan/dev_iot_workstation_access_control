<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\Workstations;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\Count;

class AnalyticsController extends Controller
{
    public function index(){
        //Card data
        $popularWorkstation = PcAccessLogs::select('workstation_id', PcAccessLogs::raw('count(*) as total'))
            ->where('occurred_at','>=', now()->startOfDay())
            ->with('workstation')
            ->groupBy('workstation_id')
            ->orderBy('total', 'desc')
            ->first();
        $totalEvents = PcAccessLogs::where('occurred_at','>=', now()->startOfDay())->count();
        $failedEvents = PcAccessLogs::where('result', 'FAIL')->where('occurred_at','>=', now()->startOfDay())->count();

        //chart data
        $topStudents = PcAccessLogs::select('student_name', PcAccessLogs::raw('count(*) as total'))
            ->whereMonth('occurred_at', now()->month)
            ->whereYear('occurred_at', now()->year)
            ->groupBy('student_name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $topCourses = PcAccessLogs::select('course', PcAccessLogs::raw('count(*) as total'))
            ->whereMonth('occurred_at', now()->month)
            ->whereYear('occurred_at', now()->year)
            ->groupBy('course')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $courseCount = PcAccessLogs::select('course', PcAccessLogs::raw('count(*) as total'))
            ->whereMonth('occurred_at', now()->month)
            ->whereYear('occurred_at', now()->year)
            ->distinct('course')
            ->count();

        $totalStudents = PcAccessLogs::select('student_external_id', PcAccessLogs::raw('count(*) as total'))
            ->whereMonth('occurred_at', now()->month)
            ->whereYear('occurred_at', now()->year)
            ->distinct('student_external_id')
            ->count();

        return view('admin.analytics.index', compact(
            'totalEvents', 'failedEvents', 'popularWorkstation',
            'topStudents', 'totalStudents',
            'topCourses', 'courseCount'));
    }
}
