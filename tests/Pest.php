<?php

use App\Models\Device;
use App\Models\PcAccessLogs;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
 // ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function sessionTestDevice(array $attributes = []): Device
{
    return Device::create(array_merge([
        'device_uid'       => 'TEST-PC-1',
        'workstation_name' => 'Test Workstation',
        'is_paired'        => true,
        'api_token'        => 'test-token',
        'last_seen_at'     => now(),
    ], $attributes));
}

function sessionTestStart(Device $device, ?string $sessionId = null, $occurredAt = null): string
{
    $sessionId = $sessionId ?: (string) Str::uuid();

    PcAccessLogs::create([
        'occurred_at'         => $occurredAt ?: now(),
        'received_at'         => now(),
        'rfid_uid'            => '04A3B2C1',
        'device_id'           => $device->id,
        'event_type'          => 'time_in',
        'result'              => 'allowed',
        'reason'              => 'Authorized',
        'session_id'          => $sessionId,
        'student_external_id' => '2024-0001',
        'student_name'        => 'Dela Cruz, Juan',
        'course'              => 'BSIT',
    ]);

    return $sessionId;
}
