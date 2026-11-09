<?php

use App\Models\PcAccessLogs;
use App\Models\User;
use App\Services\SessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('closes the previous session when the same workstation signs in again', function () {
    Http::fake([
        '*' => Http::response([
            'cardId'        => '04A3B2C1',
            'studentNumber' => '2024-0001',
            'firstName'     => 'Juan',
            'middleName'    => '',
            'lastName'      => 'Dela Cruz',
            'course'        => 'BSIT',
        ], 200),
    ]);

    $device = sessionTestDevice();
    $oldSession = sessionTestStart($device, null, now()->subMinutes(30));

    $response = $this->withHeader('X-Device-Token', 'test-token')
        ->postJson('/api/access/scan', [
            'rfid_uid' => '04A3B2C1',
            'pc_port'  => 1,
        ]);

    $response->assertOk()->assertJson(['allowed' => true]);

    expect(PcAccessLogs::where('session_id', $oldSession)->where('event_type', 'time_out')->exists())
        ->toBeTrue();

    expect(PcAccessLogs::where('event_type', 'time_in')->count())->toBe(2);
    expect(PcAccessLogs::where('session_id', $oldSession)->where('event_type', 'time_out')->value('ended_reason'))
        ->toBe('New sign-in on same workstation');
});

it('closes an orphan when the kiosk reports no active session', function () {
    $device = sessionTestDevice();
    $sessionId = sessionTestStart($device, null, now()->subMinutes(5));

    $response = $this->withHeader('X-Device-Token', 'test-token')
        ->postJson('/api/device/ping', ['session_id' => null]);

    $response->assertOk();

    expect(PcAccessLogs::where('session_id', $sessionId)->where('event_type', 'time_out')
        ->where('ended_by', SessionService::ENDED_BY_SYSTEM)->exists())->toBeTrue();
});

it('keeps the reported session and closes other sessions on the device', function () {
    $device = sessionTestDevice();
    $older = sessionTestStart($device, null, now()->subMinutes(20));
    $current = sessionTestStart($device, null, now()->subMinutes(2));

    $this->withHeader('X-Device-Token', 'test-token')
        ->postJson('/api/device/ping', ['session_id' => $current])
        ->assertOk();

    expect(PcAccessLogs::where('session_id', $older)->where('event_type', 'time_out')->exists())
        ->toBeTrue();

    expect(PcAccessLogs::where('session_id', $current)->where('event_type', 'time_out')->exists())
        ->toBeFalse();
});

it('closes open sessions immediately when staff issue a remote lock', function () {
    $device = sessionTestDevice();
    $sessionId = sessionTestStart($device);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('device.lock', $device), ['message' => 'Closing time'])
        ->assertRedirect();

    expect(PcAccessLogs::where('session_id', $sessionId)->where('event_type', 'time_out')
        ->where('ended_by', SessionService::ENDED_BY_ADMIN)->exists())->toBeTrue();

    expect($device->remoteCommands()->where('command', 'lock')->exists())->toBeTrue();
});
