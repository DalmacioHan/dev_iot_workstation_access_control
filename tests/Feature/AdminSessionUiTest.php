<?php

use App\Models\PcAccessLogs;
use App\Models\User;
use App\Services\SessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows staff to force-end a live session', function () {
    $device = sessionTestDevice();
    $sessionId = sessionTestStart($device);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('dashboard.session.force-end', $sessionId))
        ->assertOk()
        ->assertJson(['success' => true]);

    expect(PcAccessLogs::where('session_id', $sessionId)->where('event_type', 'time_out')
        ->where('ended_by', SessionService::ENDED_BY_ADMIN)->exists())->toBeTrue();
});

it('reports stale-session warnings from the polling endpoint', function () {
    $device = sessionTestDevice(['last_seen_at' => now()->subSeconds(210)]);
    sessionTestStart($device, null, now()->subMinutes(20));
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(route('dashboard.active-sessions'))
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonPath('0.is_stale', true)
        ->assertJsonPath('0.stale_minutes', 5);
});

it('does not flag a session whose workstation is still checking in', function () {
    $device = sessionTestDevice(['last_seen_at' => now()]);
    sessionTestStart($device, null, now()->subMinutes(20));
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(route('dashboard.active-sessions'))
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonPath('0.is_stale', false);
});

it('exposes workstation actions with each live session', function () {
    $device = sessionTestDevice();
    sessionTestStart($device);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->getJson(route('dashboard.active-sessions'))
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonPath('0.device_id', $device->id)
        ->assertJsonPath('0.device_name', "{$device->workstation_name} ({$device->device_uid})")
        ->assertJsonPath('0.lock_url', route('device.lock', $device->id))
        ->assertJsonPath('0.announce_url', route('device.announce', $device->id))
        ->assertJsonPath('0.device_url', route('device.show', $device->id));
});

it('renders the manage control on the dashboard live board', function () {
    $device = sessionTestDevice();
    sessionTestStart($device);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('manage-session', false)
        ->assertSee('live-session-menu', false)
        ->assertDontSee('force-end-session', false);
});
