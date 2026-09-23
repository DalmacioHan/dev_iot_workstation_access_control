<?php

use App\Http\Controllers\API\AccessController;
use App\Http\Controllers\API\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/device/activate',[DeviceController::class,'activate']);

Route::middleware('device.auth')->group(function () {
    // heartbeat route
    Route::post('/device/ping',[DeviceController::class,'heartbeat']);

    // remote command delivery (kiosk polls every ~10s) + ack
    Route::post('/device/commands',[DeviceController::class,'commands']);
    Route::post('/device/ack',[DeviceController::class,'ack']);

    // RFID scan / session endpoints used by the desktop kiosk
    Route::post('/access/scan', [AccessController::class, 'scan']);
    Route::post('/access/logout', [AccessController::class, 'logout']);
    Route::post('/access/usage', [AccessController::class, 'usage']);
});