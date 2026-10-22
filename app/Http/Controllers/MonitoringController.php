<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PcAccessLogs;
use App\Models\DeviceCommand;
use App\Models\PcAppUsage;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        // Fetch Summary Metrics
        $activeDevices   = Device::where('is_active', true)->count();
        $inactiveDevices = Device::where('is_active', false)->count();
        $grantedAccess = PcAccessLogs::where('result', 'allowed')
        ->whereBetween('occurred_at', [now()->startOfWeek(), now()])
        ->count();

        $pendingCommands = DeviceCommand::where('status', 'PENDING')->count();

        // Fetch Devices (Formatted for the UI)
        $devices = Device::latest('last_seen_at')
            ->get()
            ->map(function ($device) {
                return [
                    'id'               => $device->id,
                    'device_uid'       => $device->device_uid,
                    'workstation_name' => $device->workstation_name,
                    'pairing_code'     => $device->pairing_code,
                    'is_active'        => (bool) $device->is_active,
                    'last_seen_at'     => $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'Never',
                    'token_created_at' => $device->token_created_at ? $device->token_created_at->format('M d, Y') : 'N/A',
                    'token_expires_at' => $device->token_expires_at ? $device->token_expires_at->format('M d, Y') : 'N/A',
                ];
            });

        // Fetch Access Logs (with User and Device relationships)
        $accessLogs = PcAccessLogs::with('device')
            ->latest('occurred_at')
            ->take(50) // Limit for performance
            ->get()
            ->map(function ($log) {
                return [
                    'id'                  => $log->id,
                    'occurred_at'         => $log->occurred_at ? $log->occurred_at->format('h:i A') : '—',
                    'received_at'         => $log->received_at ? $log->received_at->format('h:i A') : '—',
                    'rfid_uid'            => $log->rfid_uid,
                    'device_id'           => $log->device_id,
                    'device_name'         => optional($log->device)->workstation_name ?? 'Unknown Workstation',
                    'event_type'          => $log->event_type,
                    'result'              => $log->result,
                    'reason'              => $log->reason,
                    'student_external_id' => $log->student_external_id,
                    'student_name'        => $log->student_name,
                    'course'              => $log->course,
                    'session_id'          => $log->session_id,
                ];
            });

        // Fetch Device Commands
        $deviceCommands = DeviceCommand::with('device')
            ->latest('created_at')
            ->take(20)
            ->get()
            ->map(function ($command) {
                return [
                    'id'              => $command->id,
                    'device_id'       => $command->device_id,
                    'device_name'     => optional($command->device)->workstation_name ?? 'Unknown Workstation',
                    'command'         => $command->command,
                    'message'         => $command->message,
                    'status'          => $command->status,
                    'acknowledged_at' => $command->acknowledged_at ? $command->acknowledged_at->format('h:i A') : null,
                    'created_at'      => $command->created_at ? $command->created_at->format('h:i A') : '—',
                ];
            });

        // Fetch App Usage Data
        $appUsage = PcAppUsage::latest('occurred_at')
            ->take(20)
            ->get()
            ->map(function ($usage) {
                return [
                    'id'          => $usage->id,
                    'session_id'  => $usage->session_id,
                    'rfid_uid'    => $usage->rfid_uid,
                    'app_name'    => $usage->app_name,
                    'seconds'     => $usage->seconds,
                    'occurred_at' => $usage->occurred_at ? $usage->occurred_at->format('h:i A') : '—',
                ];
            });

        // Pass variables down to your view
        return view('admin.monitoring.index', compact(
            'activeDevices',
            'inactiveDevices',
            'grantedAccess',
            'pendingCommands',
            'devices',
            'accessLogs',
            'deviceCommands',
            'appUsage'
        ));
    }
}