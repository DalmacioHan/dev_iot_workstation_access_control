<?php

use App\Models\PcAccessLogs;
use App\Services\SessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('closes a session idempotently', function () {
    $device = sessionTestDevice();
    $sessionId = sessionTestStart($device);
    $service = app(SessionService::class);

    expect($service->closeSession($sessionId, null, 'Session ended', SessionService::ENDED_BY_KIOSK))
        ->toBeTrue();

    expect($service->closeSession($sessionId, null, 'Session ended', SessionService::ENDED_BY_KIOSK))
        ->toBeFalse();

    $timeOuts = PcAccessLogs::where('session_id', $sessionId)
        ->where('event_type', 'time_out')
        ->get();

    expect($timeOuts)->toHaveCount(1);
    expect($timeOuts->first()->ended_by)->toBe(SessionService::ENDED_BY_KIOSK);
});

it('reaps sessions whose workstation stopped sending heartbeats', function () {
    $device = sessionTestDevice(['last_seen_at' => now()->subMinutes(10)]);
    $sessionId = sessionTestStart($device, null, now()->subMinutes(15));

    \Illuminate\Support\Facades\DB::table('system_settings')->insert([
        'key'        => 'stale_session_minutes',
        'value'      => '5',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $closed = app(SessionService::class)->reapStaleSessions();

    expect($closed)->toBe(1);

    $timeOut = PcAccessLogs::where('session_id', $sessionId)
        ->where('event_type', 'time_out')
        ->first();

    expect($timeOut)->not->toBeNull();
    expect($timeOut->ended_by)->toBe(SessionService::ENDED_BY_SYSTEM);
    expect($timeOut->ended_reason)->toContain('No heartbeat');
});
