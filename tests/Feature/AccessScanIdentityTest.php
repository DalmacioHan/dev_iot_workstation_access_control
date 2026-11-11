<?php

use App\Models\PcAccessLogs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function fakeMis(array $payload): void
{
    Http::fake(['*' => Http::response($payload, 200)]);
}

it('stores the MIS student number, not the RFID UID, as the student identity', function () {
    fakeMis([
        'StudentNo'  => '2310111-1',
        'LastName'   => 'DELA CRUZ',
        'FirstName'  => 'Juan',
        'MiddleName' => 'Reyes',
        'Sex'        => '',
        'Course'     => 'BSIT',
        'CardNo'     => '04A3B2C1',
    ]);

    sessionTestDevice();

    $this->withHeader('X-Device-Token', 'test-token')
        ->postJson('/api/access/scan', [
            'rfid_uid' => '04A3B2C1',
            'pc_port'  => 1,
        ])
        ->assertOk()
        ->assertJson(['allowed' => true]);

    $log = PcAccessLogs::where('event_type', 'time_in')->firstOrFail();

    expect($log->student_external_id)->toBe('2310111-1');
    expect($log->rfid_uid)->toBe('04A3B2C1');
});

it('does not fall back to the RFID UID when the MIS returns no student number', function () {
    fakeMis([
        'LastName' => 'DELA CRUZ',
        'FirstName' => 'Juan',
        'Course'   => 'BSIT',
        'CardNo'   => '04A3B2C1',
    ]);

    sessionTestDevice();

    $this->withHeader('X-Device-Token', 'test-token')
        ->postJson('/api/access/scan', [
            'rfid_uid' => '04A3B2C1',
            'pc_port'  => 1,
        ])
        ->assertOk()
        ->assertJson(['allowed' => true]);

    $log = PcAccessLogs::where('event_type', 'time_in')->firstOrFail();

    expect($log->student_external_id)->toBeNull();
    expect($log->rfid_uid)->toBe('04A3B2C1');
});

it('shows the student number, not the RFID UID, on the monitoring page', function () {
    $device = sessionTestDevice();
    $user = User::factory()->create();

    PcAccessLogs::create([
        'occurred_at'         => now(),
        'received_at'         => now(),
        'rfid_uid'            => '04A3B2C1',
        'device_id'           => $device->id,
        'event_type'          => 'time_in',
        'result'              => 'allowed',
        'reason'              => 'Authorized',
        'session_id'          => 'test-session',
        'student_external_id' => '2310111-1',
        'student_name'        => 'DELA CRUZ, Juan',
        'course'              => 'BSIT',
    ]);

    $this->actingAs($user)
        ->get(route('monitoring'))
        ->assertOk()
        ->assertSee('2310111-1')
        ->assertDontSee('04A3B2C1');
});
