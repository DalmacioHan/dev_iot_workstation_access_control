<?php

use App\Models\User;
use App\Services\KioskSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

it('uses the safe defaults when nothing has been saved', function () {
    expect(app(KioskSettings::class)->all())->toBe([
        'no_presence_timeout_seconds' => 300,
        'inactivity_warning_seconds' => 10,
        'shutdown_grace_seconds' => 90,
        'disable_task_manager' => false,
    ]);
});

it('clamps stored values into their safe range', function () {
    DB::table('system_settings')->insert([
        ['key' => KioskSettings::NO_PRESENCE_KEY, 'value' => '5'],
        ['key' => KioskSettings::WARNING_KEY, 'value' => '9999'],
        ['key' => KioskSettings::GRACE_KEY, 'value' => '90'],
        ['key' => KioskSettings::TASK_MANAGER_KEY, 'value' => '1'],
    ]);

    $config = app(KioskSettings::class)->all();

    expect($config['no_presence_timeout_seconds'])->toBe(30);
    expect($config['inactivity_warning_seconds'])->toBe(120);
    expect($config['shutdown_grace_seconds'])->toBe(90);
    expect($config['disable_task_manager'])->toBeTrue();
});

it('returns the kiosk config to an authenticated device', function () {
    sessionTestDevice();

    $this->getJson('/api/device/config', ['X-Device-Token' => 'test-token'])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('config.no_presence_timeout_seconds', 300)
        ->assertJsonPath('config.inactivity_warning_seconds', 10)
        ->assertJsonPath('config.shutdown_grace_seconds', 90)
        ->assertJsonPath('config.disable_task_manager', false);
});

it('rejects a config request without a device token', function () {
    $this->getJson('/api/device/config')->assertStatus(401);
});

it('shows and saves the kiosk power settings from the admin page', function () {
    $admin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($admin)
        ->get(route('settings.index'))
        ->assertOk()
        ->assertSee('Client Behavior', false)
        ->assertSee('kiosk_no_presence_timeout_seconds', false);

    $this->actingAs($admin)
        ->put(route('settings.update'), [
            'student_api_url' => 'http://localhost:5080',
            'stale_session_minutes' => 5,
            'kiosk_no_presence_timeout_seconds' => 600,
            'kiosk_inactivity_warning_seconds' => 15,
            'kiosk_shutdown_grace_seconds' => 120,
            'kiosk_disable_task_manager' => '1',
        ])
        ->assertRedirect();

    expect(app(KioskSettings::class)->all())->toBe([
        'no_presence_timeout_seconds' => 600,
        'inactivity_warning_seconds' => 15,
        'shutdown_grace_seconds' => 120,
        'disable_task_manager' => true,
    ]);
});
