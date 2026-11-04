<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $successResult = 'allowed';

        $rangeLabels = [
            'today' => 'Today',
            'last_7_days' => 'Last 7 days',
            'last_30_days' => 'Last 30 days',
            'last_90_days' => 'Last 90 days',
            'last_year' => 'Last year',
            'all_time' => 'All time',
        ];

        $range = $request->query('range', 'today');
        $range = array_key_exists($range, $rangeLabels) ? $range : 'today';
        $rangeLabel = $rangeLabels[$range];

        $now = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $weekStart = $todayStart->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->addWeek();

        $rangeStart = match ($range) {
            'today' => $now->copy()->startOfDay(),
            'last_7_days' => $now->copy()->subDays(6)->startOfDay(),
            'last_30_days' => $now->copy()->subDays(29)->startOfDay(),
            'last_90_days' => $now->copy()->subDays(89)->startOfDay(),
            'last_year' => $now->copy()->subYear()->startOfDay(),
            'all_time' => null,
        };
        $rangeEnd = $todayEnd;

        $inRange = function ($query, string $column = 'occurred_at') use ($rangeStart, $rangeEnd) {
            return $rangeStart ? $query->whereBetween($column, [$rangeStart, $rangeEnd]) : $query;
        };

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
        

        $totalLogins = $inRange(
            PcAccessLogs::query()
                ->where('event_type', 'time_in')
                ->where('result', $successResult)
        )->count('student_external_id');

        $uniqueStudents = $inRange(
            PcAccessLogs::query()
                ->where('event_type', 'time_in')
                ->where('result', $successResult)
        )->distinct('student_external_id')->count('student_external_id');

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

        $avgQuery = DB::query()
            ->fromSub($sessionTimes, 'sessions')
            ->whereNotNull('time_in_at')
            ->whereNotNull('time_out_at')
            ->whereColumn('time_out_at', '>=', 'time_in_at');

        if ($rangeStart) {
            $avgQuery->whereBetween('time_in_at', [$rangeStart, $rangeEnd]);
        }

        $avgSeconds = $avgQuery
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, time_in_at, time_out_at)) AS avg_seconds')
            ->value('avg_seconds');

        $durationSeconds = max(0, (int) round($avgSeconds ?? 0));
        $hours = intdiv($durationSeconds, 3600);
        $minutes = intdiv($durationSeconds % 3600, 60);
        $seconds = $durationSeconds % 60;
        $avgSessionDuration = "{$hours}h {$minutes}m {$seconds}s";

        // Student access chart - buckets depend on the selected range.
        $chartType = match ($range) {
            'today' => 'hour',
            'last_7_days', 'last_30_days' => 'day',
            'last_90_days' => 'week',
            'last_year', 'all_time' => 'month',
        };

        $chartStart = $rangeStart;
        if ($range === 'all_time') {
            $earliest = PcAccessLogs::query()
                ->where('event_type', 'time_in')
                ->where('result', $successResult)
                ->min('occurred_at');

            $chartStart = $earliest
                ? Carbon::parse($earliest)->startOfMonth()
                : $now->copy()->startOfMonth();
        }
        $chartEnd = $rangeEnd;

        $chartRows = PcAccessLogs::query()
            ->where('event_type', 'time_in')
            ->where('result', $successResult)
            ->whereNotNull('student_external_id')
            ->whereBetween('occurred_at', [$chartStart, $chartEnd])
            ->get(['occurred_at', 'student_external_id']);

        $buckets = [];

        if ($chartType === 'hour') {
            for ($i = 0; $i < 24; $i++) {
                $hour = $todayStart->copy()->addHours($i);
                $buckets[$hour->format('Y-m-d H:00')] = [
                    'label' => $hour->format('H:00'),
                    'male' => [],
                    'female' => [],
                ];
            }
        } elseif ($chartType === 'day') {
            for ($date = $chartStart->copy()->startOfDay(); $date->lte($chartEnd); $date->addDay()) {
                $buckets[$date->format('Y-m-d')] = [
                    'label' => $date->format('M j'),
                    'male' => [],
                    'female' => [],
                ];
            }
        } elseif ($chartType === 'week') {
            for ($week = $chartStart->copy()->startOfWeek(Carbon::MONDAY); $week->lte($chartEnd); $week->addWeek()) {
                $buckets[$week->format('Y-m-d')] = [
                    'label' => $week->format('M j'),
                    'male' => [],
                    'female' => [],
                ];
            }
        } else {
            for ($month = $chartStart->copy()->startOfMonth(); $month->lte($chartEnd); $month->addMonth()) {
                $buckets[$month->format('Y-m')] = [
                    'label' => $month->format('M Y'),
                    'male' => [],
                    'female' => [],
                ];
            }
        }

        foreach ($chartRows as $row) {
            $occurredAt = $row->occurred_at;
            $key = match ($chartType) {
                'hour' => $occurredAt->format('Y-m-d H:00'),
                'day' => $occurredAt->format('Y-m-d'),
                'week' => $occurredAt->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                'month' => $occurredAt->format('Y-m'),
            };

            if (! isset($buckets[$key])) {
                continue;
            }

            $studentId = (string) $row->student_external_id;
            if (str_ends_with($studentId, '-1')) {
                $buckets[$key]['male'][$studentId] = true;
            } elseif (str_ends_with($studentId, '-2')) {
                $buckets[$key]['female'][$studentId] = true;
            }
        }

        $male = [];
        $female = [];
        $columnChartDays = [];

        foreach ($buckets as $bucket) {
            $columnChartDays[] = $bucket['label'];
            $male[] = count($bucket['male']);
            $female[] = count($bucket['female']);
        }

        $chartGroupingLabel = match ($chartType) {
            'hour' => 'hour',
            'day' => 'day',
            'week' => 'week',
            'month' => 'month',
        };


        $courseDistribution = $inRange(
            PcAccessLogs::query()
                ->selectRaw('course, COUNT(DISTINCT student_external_id) as count')
                ->where('event_type', 'time_in')
                ->where('result', $successResult)
                ->whereNotNull('course')
                ->where('course', '<>', '')
        )
            ->groupBy('course')
            ->pluck('count', 'course')
            ->toArray();

        $totalStudents = $inRange(
            PcAccessLogs::query()
                ->where('event_type', 'time_in')
                ->where('result', $successResult)
        )->distinct('student_external_id')->count('student_external_id');

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
                    'started_at_ts' => $startedAt->timestamp,
                    'started_at_display' => $startedAt->format('h:i A'),
                    'elapsed_seconds' => (int) $elapsedSeconds,
                    'elapsed_display' => $this->formatElapsed((int) $elapsedSeconds),
                ];
            });

        return view('admin.dashboard', compact(
            'totalDevices', 'pairedDevices', 'onlineDevices',
            'weeklyVisitors', 'male', 'female', 'columnChartDays',
            'avgSessionDuration', 'courseDistribution', 'totalStudents',
            'totalLogins', 'uniqueStudents', 'activeSessions',
            'range', 'rangeLabel', 'rangeLabels', 'chartGroupingLabel'
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
                    'started_at_ts' => $startedAt->timestamp,
                    'started_at_display' => $startedAt->format('h:i A'),
                    'elapsed_seconds' => (int) $elapsedSeconds,
                    'elapsed_display' => $this->formatElapsed((int) $elapsedSeconds),
                ];
            });

        return response()->json($sessions);
    }

    private function formatElapsed(int $seconds): string
    {
        $seconds = max(0, $seconds);
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $remainingSeconds = $seconds % 60;

        return $hours > 0
            ? sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds)
            : sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
}
