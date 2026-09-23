<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceController extends Controller
{
    public function activate(Request $request)
    {
        $validated = $request->validate([
            'device_uid'   => 'required|string',
            'pairing_code' => 'required|string', 
        ]);

        $device = Device::where('device_uid', $validated['device_uid'])
                        ->where('pairing_code', $validated['pairing_code'])
                        ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Device UID or Pairing Code.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        
        $token = $device->api_token ?? $device->generateApiToken();

        
        $device->update([
            'is_active'    => true,
            'last_seen_at' => now(),
            'pairing_code' => null, 
            'api_token'    => $token, 
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Device successfully linked and activated!',
            'token'   => $token,
        ], Response::HTTP_OK);
    }
    
    public function heartbeat(Request $request)
    {
        
        $device =  $request->get('authenticated_device');

        $device->update([
            'last_seen_at'=> now()
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Heartbeat Acknowledged. Device status: Online',
            'last_seen_at'=>$device->last_seen_at->toIso8601String()
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
