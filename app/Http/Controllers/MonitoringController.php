<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\DeviceCommand;
use App\Models\PcAppUsage;
use App\Services\SessionService;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    private const TABS = ['devices', 'access', 'commands', 'apps'];

    private const PER_PAGE = 20;

    public function index(Request $request)
    {
        // Surface auto-closed sessions right away on the history view.
        app(SessionService::class)->reapStaleSessions();

        $tab = in_array($request->query('tab'), self::TABS, true)
            ? $request->query('tab')
            : 'devices';

        $search = mb_substr(trim((string) $request->query('q', '')), 0, 100);

        $resultFilter = strtolower(trim((string) $request->query('result', '')));

        if (! in_array($resultFilter, ['allowed', 'denied'], true)) {
            $resultFilter = null;
        }

        // Fetch Summary Metrics
        $pairedDevices   = Device::where('is_paired', true)->count();
        $unpairedDevices = Device::where('is_paired', false)->count();
        $grantedAccess = PcAccessLogs::where('result', 'allowed')
            ->whereBetween('occurred_at', [now()->startOfWeek(), now()])
            ->count();

        $pendingCommands = DeviceCommand::where('status', 'PENDING')->count();

        // Only the active tab is queried, so a page view never pays for the
        // other three datasets.
        $devices = null;
        $accessLogs = null;
        $deviceCommands = null;
        $appUsage = null;

        if ($tab === 'devices') {
            $devices = Device::query()
                ->when($search !== '', function ($query) use ($search) {
                    $like = '%' . $search . '%';

                    $query->where(function ($query) use ($like) {
                        $query->where('workstation_name', 'like', $like)
                            ->orWhere('pairing_code', 'like', $like);
                    });
                })
                ->orderByDesc('last_seen_at')
                ->orderByDesc('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(function (Device $device) {
                    return [
                        'id'               => $device->id,
                        'workstation_name' => $device->workstation_name,
                        'pairing_code'     => $device->pairing_code,
                        'is_paired'        => (bool) $device->is_paired,
                        'last_seen_at'     => $device->last_seen_at
                            ? $device->last_seen_at->diffForHumans()
                            : 'Never',
                        'last_seen_title'  => $device->last_seen_at
                            ? $device->last_seen_at->format('M d, Y g:i A')
                            : 'Never',
                    ];
                });
        }

        if ($tab === 'access') {
            $accessLogs = PcAccessLogs::query()
                ->with('device')
                ->when($search !== '', function ($query) use ($search) {
                    $like = '%' . $search . '%';

                    $query->where(function ($query) use ($like) {
                        $query->where('student_name', 'like', $like)
                            ->orWhere('student_external_id', 'like', $like)
                            ->orWhere('rfid_uid', 'like', $like)
                            ->orWhere('course', 'like', $like)
                            ->orWhere('event_type', 'like', $like)
                            ->orWhere('result', 'like', $like)
                            ->orWhere('session_id', 'like', $like)
                            ->orWhereHas('device', function ($device) use ($like) {
                                $device->where('workstation_name', 'like', $like);
                            });
                    });
                })
                ->when($resultFilter !== null, function ($query) use ($resultFilter) {
                    $query->where('result', $resultFilter);
                })
                ->orderByDesc('occurred_at')
                ->orderByDesc('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(function (PcAccessLogs $log) {
                    return [
                        'id'                  => $log->id,
                        'occurred_at'         => $log->occurred_at
                            ? $log->occurred_at->format('M d, Y g:i A')
                            : '—',
                        'received_at'         => $log->received_at
                            ? $log->received_at->format('M d, Y g:i A')
                            : '—',
                        'rfid_uid'            => $log->rfid_uid,
                        'device_id'           => $log->device_id,
                        'device_name'         => optional($log->device)->workstation_name ?? 'Unknown Workstation',
                        'event_type'          => $log->event_type,
                        'result'              => $log->result,
                        'reason'              => $log->reason,
                        'ended_reason'        => $log->ended_reason,
                        'ended_by'            => $log->ended_by,
                        'student_external_id' => $log->student_external_id,
                        'student_name'        => $log->student_name,
                        'course'              => $log->course,
                        'session_id'          => $log->session_id,
                    ];
                });
        }

        if ($tab === 'commands') {
            $deviceCommands = DeviceCommand::query()
                ->with('device')
                ->when($search !== '', function ($query) use ($search) {
                    $like = '%' . $search . '%';

                    $query->where(function ($query) use ($like) {
                        $query->where('command', 'like', $like)
                            ->orWhere('message', 'like', $like)
                            ->orWhere('status', 'like', $like)
                            ->orWhereHas('device', function ($device) use ($like) {
                                $device->where('workstation_name', 'like', $like);
                            });
                    });
                })
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(function (DeviceCommand $command) {
                    return [
                        'id'              => $command->id,
                        'device_id'       => $command->device_id,
                        'device_name'     => optional($command->device)->workstation_name ?? 'Unknown Workstation',
                        'command'         => $command->command,
                        'message'         => $command->message,
                        'status'          => $command->status,
                        'acknowledged_at' => $command->acknowledged_at
                            ? $command->acknowledged_at->format('M d, Y g:i A')
                            : null,
                        'created_at'      => $command->created_at
                            ? $command->created_at->format('M d, Y g:i A')
                            : '—',
                    ];
                });
        }

        if ($tab === 'apps') {
            // The student number comes from the session's access log, never
            // from the RFID UID.
            $appUsage = PcAppUsage::query()
                ->with('accessLog')
                ->when($search !== '', function ($query) use ($search) {
                    $like = '%' . $search . '%';

                    $query->where(function ($query) use ($like) {
                        $query->where('app_name', 'like', $like)
                            ->orWhere('session_id', 'like', $like)
                            ->orWhereHas('accessLog', function ($log) use ($like) {
                                $log->where('student_name', 'like', $like)
                                    ->orWhere('student_external_id', 'like', $like);
                            });
                    });
                })
                ->orderByDesc('occurred_at')
                ->orderByDesc('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(function (PcAppUsage $usage) {
                    return [
                        'id'                  => $usage->id,
                        'session_id'          => $usage->session_id,
                        'student_external_id' => optional($usage->accessLog)->student_external_id,
                        'student_name'        => optional($usage->accessLog)->student_name,
                        'app_name'            => $usage->app_name,
                        'seconds'             => $usage->seconds,
                        'occurred_at'         => $usage->occurred_at
                            ? $usage->occurred_at->format('M d, Y g:i A')
                            : '—',
                    ];
                });
        }

        return view('admin.monitoring.index', compact(
            'tab',
            'search',
            'resultFilter',
            'pairedDevices',
            'unpairedDevices',
            'grantedAccess',
            'pendingCommands',
            'devices',
            'accessLogs',
            'deviceCommands',
            'appUsage'
        ));
    }
}
