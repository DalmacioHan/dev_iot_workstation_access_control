<?php

use App\Models\Device;
use App\Models\DeviceCommand;
use App\Models\PcAccessLogs;
use App\Models\PcAppUsage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function monitoringDevice(string $name, array $attributes = []): Device
{
    return sessionTestDevice(array_merge([
        'workstation_name' => $name,
        'api_token'        => 'token-' . md5($name),
    ], $attributes));
}

function monitoringAccessLog(Device $device, array $attributes = []): PcAccessLogs
{
    return PcAccessLogs::create(array_merge([
        'occurred_at'         => now(),
        'received_at'         => now(),
        'rfid_uid'            => 'RID-' . uniqid(),
        'device_id'           => $device->id,
        'event_type'          => 'time_in',
        'result'              => 'allowed',
        'reason'              => 'Authorized',
        'session_id'          => 'ses-' . uniqid(),
        'student_external_id' => '2024-0001',
        'student_name'        => 'DELA CRUZ, Juan',
        'course'              => 'BSIT',
    ], $attributes));
}

it('paginates every access event instead of only the latest ten', function () {
    $device = sessionTestDevice();

    foreach (range(1, 30) as $i) {
        monitoringAccessLog($device, [
            'occurred_at'  => now()->subMinutes($i),
            'student_name' => sprintf('Student %02d', $i),
        ]);
    }

    $this->actingAs(User::factory()->create())
        ->get(route('monitoring', ['tab' => 'access']))
        ->assertOk()
        ->assertViewHas('accessLogs', function ($logs) {
            return $logs->total() === 30
                && $logs->perPage() === 20
                && $logs->count() === 20
                && $logs->currentPage() === 1;
        });

    $this->actingAs(User::factory()->create())
        ->get(route('monitoring', ['tab' => 'access', 'page' => 2]))
        ->assertOk()
        ->assertViewHas('accessLogs', function ($logs) {
            return $logs->total() === 30
                && $logs->count() === 10
                && $logs->currentPage() === 2;
        });
});

it('searches access events by student, id, and workstation', function () {
    $pcOne = monitoringDevice('PC-01');
    $pcTwo = monitoringDevice('PC-02');

    monitoringAccessLog($pcOne, [
        'student_name'        => 'DELA CRUZ, Juan',
        'student_external_id' => '2310111-1',
    ]);

    monitoringAccessLog($pcTwo, [
        'student_name'        => 'SANTOS, Maria',
        'student_external_id' => '2310222-2',
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'access', 'q' => 'DELA CRUZ']))
        ->assertOk()
        ->assertSee('DELA CRUZ, Juan')
        ->assertDontSee('SANTOS, Maria');

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'access', 'q' => '2310222-2']))
        ->assertOk()
        ->assertSee('SANTOS, Maria')
        ->assertDontSee('DELA CRUZ, Juan');

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'access', 'q' => 'PC-02']))
        ->assertOk()
        ->assertSee('SANTOS, Maria')
        ->assertDontSee('DELA CRUZ, Juan');
});

it('filters access events by result', function () {
    $device = sessionTestDevice();

    monitoringAccessLog($device, ['student_name' => 'ALLOWED, Student', 'result' => 'allowed']);
    monitoringAccessLog($device, ['student_name' => 'DENIED, Student', 'result' => 'denied']);

    $this->actingAs(User::factory()->create())
        ->get(route('monitoring', ['tab' => 'access', 'result' => 'denied']))
        ->assertOk()
        ->assertSee('DENIED, Student')
        ->assertDontSee('ALLOWED, Student');
});

it('searches commands by command, status, and workstation', function () {
    $pcOne = monitoringDevice('PC-01');
    $pcTwo = monitoringDevice('PC-02');

    DeviceCommand::create([
        'device_id' => $pcOne->id,
        'command'   => 'REBOOT',
        'message'   => 'Restart for maintenance',
        'status'    => 'PENDING',
    ]);

    DeviceCommand::create([
        'device_id' => $pcTwo->id,
        'command'   => 'SHUTDOWN',
        'message'   => 'End of day',
        'status'    => 'ACKNOWLEDGED',
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'commands', 'q' => 'REBOOT']))
        ->assertOk()
        ->assertSee('REBOOT')
        ->assertDontSee('SHUTDOWN');

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'commands', 'q' => 'PC-02']))
        ->assertOk()
        ->assertSee('SHUTDOWN')
        ->assertDontSee('REBOOT');
});

it('searches application usage by app and student', function () {
    $device = sessionTestDevice();
    $log = monitoringAccessLog($device, [
        'student_name'        => 'DELA CRUZ, Juan',
        'student_external_id' => '2310111-1',
    ]);

    PcAppUsage::create([
        'session_id'  => $log->session_id,
        'rfid_uid'    => 'RID-1',
        'app_name'    => 'Google Chrome',
        'seconds'     => 125,
        'occurred_at' => now(),
    ]);

    PcAppUsage::create([
        'session_id'  => $log->session_id,
        'rfid_uid'    => 'RID-1',
        'app_name'    => 'Microsoft Word',
        'seconds'     => 60,
        'occurred_at' => now()->subMinute(),
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'apps', 'q' => 'Chrome']))
        ->assertOk()
        ->assertSee('Google Chrome')
        ->assertDontSee('Microsoft Word');

    $this->actingAs($user)
        ->get(route('monitoring', ['tab' => 'apps', 'q' => '2310111-1']))
        ->assertOk()
        ->assertSee('Google Chrome')
        ->assertSee('Microsoft Word');
});

it('paginates and searches devices', function () {
    foreach (range(1, 25) as $i) {
        sessionTestDevice([
            'workstation_name' => sprintf('PC-%02d', $i),
            'api_token'        => 'token-pc-' . $i,
            'last_seen_at'     => now()->subMinutes($i),
        ]);
    }

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('monitoring'))
        ->assertOk()
        ->assertViewHas('tab', 'devices')
        ->assertViewHas('devices', function ($devices) {
            return $devices->total() === 25
                && $devices->perPage() === 20
                && $devices->count() === 20;
        });

    $this->actingAs($user)
        ->get(route('monitoring', ['q' => 'PC-25']))
        ->assertOk()
        ->assertSee('PC-25')
        ->assertDontSee('PC-24');
});

it('falls back to the devices tab for an unknown tab', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('monitoring', ['tab' => 'bogus']))
        ->assertOk()
        ->assertViewHas('tab', 'devices')
        ->assertViewHas('accessLogs', null);
});
