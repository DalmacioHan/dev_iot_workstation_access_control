<?php

use App\Models\User;
use App\Services\MisSettings;
use App\Services\MisStudentLookup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();

    config([
        'services.mis.url' => 'http://localhost:5080',
        'services.mis.student_path' => '/api/students/{cardId}',
    ]);
});

function misSetting(string $value): void
{
    DB::table('system_settings')->updateOrInsert(
        ['key' => MisSettings::URL_KEY],
        ['value' => $value, 'created_at' => now(), 'updated_at' => now()]
    );
}

it('falls back to the environment URL when no override is saved', function () {
    DB::table('system_settings')->where('key', MisSettings::URL_KEY)->delete();

    $mis = app(MisSettings::class);

    expect($mis->baseUrl())->toBe('http://localhost:5080');
    expect($mis->endpointFor())->toBe('http://localhost:5080/api/students/{cardId}');
});

it('uses the saved settings URL over the environment value', function () {
    misSetting('https://uisa.example.edu/mis/');

    $mis = app(MisSettings::class);

    expect($mis->baseUrl())->toBe('https://uisa.example.edu/mis');
    expect($mis->endpointFor('04A3B2C1'))
        ->toBe('https://uisa.example.edu/mis/api/students/04A3B2C1');
});

it('routes RFID lookups through the saved MIS URL', function () {
    misSetting('https://uisa.example.edu/mis');

    Http::fake([
        '*' => Http::response([
            'StudentNo'  => '2310111-1',
            'LastName'   => 'DELA CRUZ',
            'FirstName'  => 'Juan',
            'MiddleName' => 'Reyes',
            'Sex'        => '',
            'Course'     => 'BSIT',
            'CardNo'     => '04A3B2C1',
        ], 200),
    ]);

    [$student, $reason] = app(MisStudentLookup::class)->lookup('04A3B2C1');

    expect($reason)->toBeNull();
    expect($student)->not->toBeNull();
    expect($student['studentNumber'])->toBe('2310111-1');

    Http::assertSent(fn ($request) => $request->url()
        === 'https://uisa.example.edu/mis/api/students/04A3B2C1');
});

it('shows the effective MIS endpoint on the settings page', function () {
    DB::table('system_settings')->where('key', MisSettings::URL_KEY)->delete();
    $admin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($admin)
        ->get(route('settings.index'))
        ->assertOk()
        ->assertSee('http://localhost:5080/api/students/{cardId}');
});

it('saves the MIS URL and applies it without a config cache clear', function () {
    $admin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($admin)
        ->put(route('settings.update'), [
            'student_api_url' => 'https://uisa.example.edu/mis',
            'stale_session_minutes' => 5,
            'kiosk_no_presence_timeout_seconds' => 300,
            'kiosk_inactivity_warning_seconds' => 10,
            'kiosk_shutdown_grace_seconds' => 90,
        ])
        ->assertRedirect();

    expect(app(MisSettings::class)->baseUrl())
        ->toBe('https://uisa.example.edu/mis');
});
