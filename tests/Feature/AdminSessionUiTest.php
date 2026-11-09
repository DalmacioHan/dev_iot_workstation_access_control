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
