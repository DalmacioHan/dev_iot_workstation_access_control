<?php

use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function activationDevice(): Device
{
    return Device::create([
        'workstation_name' => 'PC-TEST',
        'pairing_code'     => 'ABC123',
        'is_paired'        => false,
    ]);
}

it('activates a device with its workstation name and pairing code', function () {
    activationDevice();

    $this->postJson('/api/device/activate', [
        'workstation_name' => 'PC-TEST',
        'pairing_code'     => 'abc123',
    ])->assertOk()
      ->assertJsonPath('workstation_name', 'PC-TEST')
      ->assertJsonStructure(['token']);

    $device = Device::where('workstation_name', 'PC-TEST')->first();

    expect($device->is_paired)->toBeTrue()
        ->and($device->pairing_code)->toBeNull()
        ->and($device->api_token)->not->toBeNull();
});

it('rejects a wrong pairing code', function () {
    activationDevice();

    $this->postJson('/api/device/activate', [
        'workstation_name' => 'PC-TEST',
        'pairing_code'     => 'WRONG1',
    ])->assertStatus(401);

    expect(Device::first()->is_paired)->toBeFalse();
});

it('still accepts device_uid as an alias', function () {
    activationDevice();

    $this->postJson('/api/device/activate', [
        'device_uid'   => 'PC-TEST',
        'pairing_code' => 'ABC123',
    ])->assertOk()->assertJsonStructure(['token']);
});
