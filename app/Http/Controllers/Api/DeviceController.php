<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\KioskSettings;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    public function __construct(
        private SessionService $sessions,
        private KioskSettings $kiosk
    ) {
    }

    public function activate(Request $request)
    {
        // devices.device_uid was dropped from the schema; workstation_name is
        // now the device identity. device_uid is still accepted as an alias so
        // older clients keep working.
        $validated = $request->validate([
            'workstation_name' => 'required_without:device_uid|string|max:255',
            'device_uid'       => 'required_without:workstation_name|string|max:255',
            'pairing_code'     => 'required|string|max:32',
        ]);

        $name = trim((string) ($validated['workstation_name'] ?? $validated['device_uid']));
        $code = strtoupper(trim($validated['pairing_code']));

        $device = Device::where('workstation_name', $name)
                        ->where('pairing_code', $code)
                        ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid workstation name or pairing code.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        
        $token = $device->api_token ?? $device->generateApiToken();

        
        $device->update([
            'is_paired'    => true,
            'last_seen_at' => now(),
            'pairing_code' => null, 
            'api_token'    => $token, 
        ]);
        return response()->json([
            'success'          => true,
            'message'          => 'Device successfully linked and activated!',
            'token'            => $token,
            'workstation_name' => $device->workstation_name,
        ], Response::HTTP_OK);
    }
    
    public function heartbeat(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'nullable|string|max:64',
        ]);

        $device = $request->get('authenticated_device');

        $device->update([
            'last_seen_at' => now(),
        ]);

        // The kiosk reports which session (if any) it currently owns. Any
        // other open session on this device is an orphan and gets closed.
        $this->sessions->reconcileFromHeartbeat(
            $device,
            $validated['session_id'] ?? null
        );

        return response()->json([
            'success'      => true,
            'message'      => 'Heartbeat Acknowledged. Device status: Online',
            'last_seen_at' => $device->last_seen_at->toIso8601String(),
        ], Response::HTTP_OK);
    }

    /**
     * Global kiosk behavior config (power / idle timers + Task Manager flag).
     * The desktop client (through the privileged agent) fetches this at
     * startup and keeps the last copy as its offline fallback.
     */
    public function config()
    {
        return response()->json([
            'success'    => true,
            'config'     => $this->kiosk->all(),
            'version'    => $this->kiosk->version(),
            'fetched_at' => now()->toIso8601String(),
        ], Response::HTTP_OK);
    }

    /**
     * Lightweight poll the kiosk calls frequently (~10s). Returns the
     * latest pending remote command (e.g. a staff-issued lock) or null.
     * Does NOT touch last_seen_at - that stays on the 60s heartbeat.
     */
    public function commands(Request $request)
    {
        $device = $request->get('authenticated_device');

        $command = $device->remoteCommands()
                          ->where('status', 'pending')
                          ->orderBy('id')
                          ->first();

        return response()->json([
            'success' => true,
            'command' => $command ? [
                'id'      => $command->id,
                'type'    => $command->command,
                'message' => $command->message,
            ] : null,
        ], Response::HTTP_OK);
    }

    /**
     * Marks a delivered command as completed so it is not re-sent.
     */
    public function ack(Request $request)
    {
        $validated = $request->validate([
            'command_id' => 'required|integer',
        ]);

        $device = $request->get('authenticated_device');

        $command = $device->remoteCommands()
                          ->where('id', $validated['command_id'])
                          ->where('status', 'pending')
                          ->first();

        if (!$command) {
            return response()->json([
                'success' => false,
                'message' => 'No pending command with that id.',
            ], Response::HTTP_NOT_FOUND);
        }

        $command->update([
            'status'          => 'completed',
            'acknowledged_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Command acknowledged.',
        ], Response::HTTP_OK);
    }
}
