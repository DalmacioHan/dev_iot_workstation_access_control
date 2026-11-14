<?php

use App\Models\User;
use App\Services\ClientSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

it('uses the safe defaults when nothing has been saved', function () {
    expect(app(ClientSettings::class)->all())->toBe([
        'no_presence_timeout_seconds' => 300,
        'inactivity_warning_seconds' => 10,
        'shutdown_grace_seconds' => 90,
        'disable_task_manager' => false,
    ]);
});

it('clamps stored values into their safe range', function () {
    DB::table('system_settings')->insert([
        ['key' => ClientSettings::NO_PRESENCE_KEY, 'value' => '5'],
        ['key' => ClientSettings::WARNING_KEY, 'value' => '9999'],
        ['key' => ClientSettings::GRACE_KEY, 'value' => '90'],
        ['key' => ClientSettings::TASK_MANAGER_KEY, 'value' => '1'],
    ]);

    $config = app(ClientSettings::class)->all();

    expect($config['no_presence_timeout_seconds'])->toBe(30);
    expect($config['inactivity_warning_seconds'])->toBe(120);
    expect($config['shutdown_grace_seconds'])->toBe(90);
    expect($config['disable_task_manager'])->toBeTrue();
});

it('reads legacy kiosk keys for backward compatibility', function () {
    DB::table('system_settings')->insert([
        ['key' => ClientSettings::LEGACY_NO_PRESENCE_KEY, 'value' => '420'],
        ['key' => ClientSettings::LEGACY_WARNING_KEY, 'value' => '12'],
        ['key' => ClientSettings::LEGACY_GRACE_KEY, 'value' => '60'],
        ['key' => ClientSettings::LEGACY_TASK_MANAGER_KEY, 'value' => 'true'],
    ]);

    expect(app(ClientSettings::class)->all())->toBe([
        'no_presence_timeout_seconds' => 420,
        'inactivity_warning_seconds' => 12,
        'shutdown_grace_seconds' => 60,
        'disable_task_manager' => true,
    ]);
});

it('returns the client config to an authenticated device', function () {
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

it('shows and saves the client behavior settings from the admin page', function () {
    $admin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($admin)
        ->get(route('settings.index'))
        ->assertOk()
        ->assertSee('Client Behavior', false)
        ->assertSee('client_no_presence_timeout_seconds', false);

    $this->actingAs($admin)
        ->put(route('settings.update'), [
            'student_api_url' => 'http://localhost:5080',
            'stale_session_minutes' => 5,
            'client_no_presence_timeout_seconds' => 600,
            'client_inactivity_warning_seconds' => 15,
            'client_shutdown_grace_seconds' => 120,
            'client_disable_task_manager' => '1',
        ])
        ->assertRedirect(route('settings.index', ['tab' => 'client']));

    expect(app(ClientSettings::class)->all())->toBe([
        'no_presence_timeout_seconds' => 600,
        'inactivity_warning_seconds' => 15,
        'shutdown_grace_seconds' => 120,
        'disable_task_manager' => true,
    ]);

    expect(DB::table('system_settings')->where('key', ClientSettings::NO_PRESENCE_KEY)->value('value'))
        ->toBe('600');
});
