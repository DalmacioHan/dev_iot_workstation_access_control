<?php

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function unpairTestDevice(array $attributes = []): Device
{
    return Device::create(array_merge([
        'workstation_name' => 'PC-UNPAIR',
        'pairing_code'     => null,
        'is_paired'        => true,
        'api_token'        => 'unpair-test-token',
        'last_seen_at'     => now(),
    ], $attributes));
}

it('unpairs a device through the device API and invalidates its token', function () {
    $device = unpairTestDevice();

    $this->withHeader('X-Device-Token', 'unpair-test-token')
        ->postJson('/api/device/unpair')
        ->assertOk()
        ->assertJsonPath('paired', false)
        ->assertJsonStructure(['pairing_code']);

    $device->refresh();

    expect($device->is_paired)->toBeFalse()
        ->and($device->api_token)->toBeNull()
        ->and($device->last_seen_at)->toBeNull()
        ->and($device->pairing_code)->not->toBeNull();

    // The revoked token can no longer read the config.
    $this->withHeader('X-Device-Token', 'unpair-test-token')
        ->getJson('/api/device/config')
        ->assertStatus(401);
});

it('rejects a device unpair without a valid token', function () {
    unpairTestDevice();

    $this->postJson('/api/device/unpair')->assertStatus(401);

    $this->withHeader('X-Device-Token', 'not-a-real-token')
        ->postJson('/api/device/unpair')
        ->assertStatus(401);

    expect(Device::first()->is_paired)->toBeTrue();
});

it('keeps a pairing code stable when unpair runs twice', function () {
    $device = unpairTestDevice();

    $first = $device->unpair();
    $second = $device->fresh()->unpair();

    expect($first)->not->toBeEmpty()
        ->and($second)->toBe($first);
});

it('unpairs a device from the dashboard and revokes its token', function () {
    $device = unpairTestDevice();
    $admin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($admin)
        ->put(route('device.update', $device), [
            'workstation_name' => 'PC-UNPAIR',
            'is_paired'        => 0,
        ])
        ->assertRedirect(route('device', $device));

    $device->refresh();

    expect($device->is_paired)->toBeFalse()
        ->and($device->api_token)->toBeNull()
        ->and($device->pairing_code)->not->toBeNull();

    $this->withHeader('X-Device-Token', 'unpair-test-token')
        ->getJson('/api/device/config')
        ->assertStatus(401);
});
