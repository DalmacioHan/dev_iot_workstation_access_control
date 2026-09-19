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
}
