<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
                ->where('event_type', 'time_in')
                ->where('result', $successResult);
        };

        // Device stats
        $totalDevices = Device::count();
        $pairedDevices = Device::where('is_paired', 1)->count();
        $onlineDevices = Device::where('is_paired', 1)
        ->where('last_seen_at', '>=', now()->subSeconds(90))
        ->count();
        

        $totalLoginsToday= PcAccessLogs::whereDate('occurred_at', Carbon::today())
        ->where('event_type', 'time_in')
        ->where('result','allowed')
        ->count('student_external_id');
        $weekStart = Carbon::today()->startOfWeek(Carbon::MONDAY);
        $uniqueStudentsToday = PcAccessLogs::whereDate('occurred_at', Carbon::today())
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->distinct('student_external_id')
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
                'MIN(CASE WHEN event_type = ? AND result = ? THEN occurred_at END) AS time_in_at',
                ['time_in', $successResult]
            )
            ->selectRaw(
                'MIN(CASE WHEN event_type = ? THEN occurred_at END) AS time_out_at',
                ['time_out']
            )
            ->whereNotNull('session_id')
            ->groupBy('session_id');

        $avgSeconds = DB::query()
            ->fromSub($sessionTimes, 'sessions')
            ->whereNotNull('time_in_at')
            ->whereNotNull('time_out_at')
            ->whereColumn('time_out_at', '>=', 'time_in_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, time_in_at, time_out_at)) AS avg_seconds')
            ->value('avg_seconds');

        $durationSeconds = max(0, (int) round($avgSeconds ?? 0));
        $hours = intdiv($durationSeconds, 3600);
        $minutes = intdiv($durationSeconds % 3600, 60);
        $seconds = $durationSeconds % 60;
        $avgSessionDuration = "{$hours}h {$minutes}m {$seconds}s";

        // Weekly unique students by gender (assumes ID suffix -1 = male, -2 = female)
        $male = [];
        $female = [];
        $columnChartDays = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $nextDate = $date->copy()->addDay();
            $columnChartDays[] = $date->format('l');

            $male[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('event_type', 'time_in')
                ->where('result', 'allowed')
                ->where('student_external_id', 'like', '%-1')
                ->distinct()
                ->count('student_external_id');

            $female[] = PcAccessLogs::whereDate('occurred_at', $date)
                ->where('event_type', 'time_in')
                ->where('result', 'allowed')
                ->where('student_external_id', 'like', '%-2')
                ->distinct()
                ->count('student_external_id');
        }


        $courseDistribution = PcAccessLogs::selectRaw('course, COUNT(DISTINCT student_external_id) as count')
            ->where('event_type', 'time_in')
            ->where('result', 'allowed')
            ->whereNotNull('course')
            ->where('course', '<>', '')
            ->groupBy('course')
            ->pluck('count', 'course')
            ->toArray();

        $totalStudents = PcAccessLogs::distinct('student_external_id')
        ->where('event_type', 'time_in')
        ->where('result', 'allowed')
        ->count('student_external_id');

        $pairedDevices = Device::where('is_paired', 1)->count();

        // Active PC sessions (time_in without corresponding time_out)
        $activeSessions = PcAccessLogs::query()
            ->select(
                'pc_access_logs.session_id',
                'pc_access_logs.device_id',
                'pc_access_logs.student_name',
                'pc_access_logs.student_external_id',
                'pc_access_logs.course',
                'pc_access_logs.occurred_at as started_at'
            )
            ->selectRaw('devices.workstation_name, devices.device_uid')
            ->join('devices', 'devices.id', '=', 'pc_access_logs.device_id')
            ->where('pc_access_logs.event_type', 'time_in')
            ->where('pc_access_logs.result', 'allowed')
            ->whereNotNull('pc_access_logs.session_id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('pc_access_logs as logout_log')
                    ->whereColumn('logout_log.session_id', 'pc_access_logs.session_id')
                    ->where('logout_log.event_type', 'time_out');
            })
            ->orderBy('pc_access_logs.occurred_at', 'desc')
            ->get()
            ->map(function ($session) {
                $startedAt = Carbon::parse($session->started_at);
                $elapsedSeconds = $startedAt->diffInSeconds(Carbon::now());

                return [
                    'session_id' => $session->session_id,
                    'student_name' => $session->student_name,
                    'student_external_id' => $session->student_external_id,
                    'course' => $session->course,
                    'workstation_name' => $session->workstation_name,
                    'device_uid' => $session->device_uid,
                    'started_at' => $startedAt->toIso8601String(),
                    'started_at_display' => $startedAt->format('h:i A'),
                    'elapsed_seconds' => $elapsedSeconds,
                ];
            });

        return view('admin.dashboard', compact(
            'totalDevices', 'pairedDevices', 'onlineDevices',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'avgSessionDuration', 'courseDistribution', 'totalStudents',
            'totalLoginsToday', 'uniqueStudentsToday', 'activeSessions'
        ));
    }

    public function activeSessions(): JsonResponse
    {
        $sessions = PcAccessLogs::query()
            ->select(
                'pc_access_logs.session_id',
                'pc_access_logs.device_id',
                'pc_access_logs.student_name',
                'pc_access_logs.student_external_id',
                'pc_access_logs.course',
                'pc_access_logs.occurred_at as started_at'
            )
            ->selectRaw('devices.workstation_name, devices.device_uid')
            ->join('devices', 'devices.id', '=', 'pc_access_logs.device_id')
            ->where('pc_access_logs.event_type', 'time_in')
            ->where('pc_access_logs.result', 'allowed')
            ->whereNotNull('pc_access_logs.session_id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('pc_access_logs as logout_log')
                    ->whereColumn('logout_log.session_id', 'pc_access_logs.session_id')
                    ->where('logout_log.event_type', 'time_out');
            })
            ->orderBy('pc_access_logs.occurred_at', 'desc')
            ->get()
            ->map(function ($session) {
                $startedAt = Carbon::parse($session->started_at);
                $elapsedSeconds = $startedAt->diffInSeconds(Carbon::now());

                return [
                    'session_id' => $session->session_id,
                    'student_name' => $session->student_name,
                    'student_external_id' => $session->student_external_id,
                    'course' => $session->course,
                    'workstation_name' => $session->workstation_name,
                    'device_uid' => $session->device_uid,
                    'started_at' => $startedAt->toIso8601String(),
                    'started_at_display' => $startedAt->format('h:i A'),
                    'elapsed_seconds' => $elapsedSeconds,
                ];
            });

        return response()->json($sessions);
    }
}
