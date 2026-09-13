<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceWorkstation;
use App\Models\PcAccessLogs;
use App\Models\PcAppUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AccessController extends Controller
{
    /**
     * Validate one RFID scan against the university MIS and log the result.
     *
     * Expected body (sent by the desktop kiosk app):
     *   rfid_uid     - card id, uppercase hex without separators ("04A3B2C1")
     *   pc_port      - 1 or 2 (which PC/zone on this device)
     *   occurred_at  - optional ISO-8601 scan time (defaults to now)
     *
     * Response:
     *   200 {"allowed":true,  "session_id":"...", "student":{...}}
     *   200 {"allowed":false, "reason":"Card is not registered."}
     *
     * The device is resolved by the `device.auth` middleware and lives in
     * $request->authenticated_device.
     */
    public function scan(Request $request)
    {
        $validated = $request->validate([
            'rfid_uid'    => 'required|string|max:100',
            'pc_port'     => 'required|integer|in:1,2',
            'occurred_at' => 'sometimes|date',
        ]);

        $device  = $request->get('authenticated_device');
        $pcPort  = (int) $validated['pc_port'];
        $cardId  = strtoupper($validated['rfid_uid']);
        $occurredAt = isset($validated['occurred_at'])
            ? \Illuminate\Support\Carbon::parse($validated['occurred_at'])
            : now();

        $mapping = DeviceWorkstation::where('device_id', $device->id)
            ->where('pc_port', $pcPort)
            ->first();

        [$student, $reason] = $this->lookupStudentInMis($cardId);

        if ($student === null) {
            $this->writeLog([
                'occurred_at'    => $occurredAt,
                'rfid_uid'       => $cardId,
                'workstation_id' => $mapping?->workstation_id,
                'event_type'     => 'denied',
                'result'         => 'denied',
                'reason'         => $reason,
            ]);

            return response()->json([
                'allowed' => false,
                'reason'  => $reason,
            ], Response::HTTP_OK);
        }

        $sessionId = Str::uuid()->toString();

        $this->writeLog([
            'occurred_at'    => $occurredAt,
            'rfid_uid'       => $cardId,
            'workstation_id' => $mapping?->workstation_id,
            'event_type'     => 'time_in',
            'result'         => 'allowed',
            'reason'         => 'Authorized',
            'session_id'     => $sessionId,
            'student'        => $student,
        ]);

        return response()->json([
            'allowed'    => true,
            'session_id' => $sessionId,
            'student'    => $student,
        ], Response::HTTP_OK);
    }

    /**
     * Close an open session. The kiosk calls this on lock / shutdown / timeout.
     *
     * Expected body:
     *   session_id   - id returned by /api/access/scan
     *   occurred_at  - optional ISO-8601 time the session ended
     */
    public function logout(Request $request)
    {
        $validated = $request->validate([
            'session_id'  => 'required|string|max:64',
            'occurred_at' => 'sometimes|date',
        ]);

        $occurredAt = isset($validated['occurred_at'])
            ? \Illuminate\Support\Carbon::parse($validated['occurred_at'])
            : now();

        $entry = PcAccessLogs::where('session_id', $validated['session_id'])
            ->where('event_type', 'time_in')
            ->first();

        if ($entry === null) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown or already closed session.',
            ], Response::HTTP_NOT_FOUND);
        }

        PcAccessLogs::create([
            'occurred_at'         => $occurredAt,
            'received_at'         => now(),
            'rfid_uid'            => $entry->rfid_uid,
            'workstation_id'      => $entry->workstation_id,
            'event_type'          => 'time_out',
            'result'              => 'allowed',
            'reason'              => 'Session ended',
            'session_id'          => $entry->session_id,
            'student_external_id' => $entry->student_external_id,
            'student_name'        => $entry->student_name,
            'course'              => $entry->course,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Session closed.',
            'session_id' => $entry->session_id,
        ], Response::HTTP_OK);
    }

    /**
     * Record foreground app usage for one session.
     *
     * Expected body (sent by the desktop kiosk):
     *   session_id  - id returned by /api/access/scan
     *   occurred_at - optional ISO-8601 flush time (defaults to now)
     *   apps        - [{ "app": "chrome", "seconds": 120 }, ...]
     */
    public function usage(Request $request)
    {
        $validated = $request->validate([
            'session_id'     => 'required|string|max:64',
            'occurred_at'    => 'sometimes|date',
            'apps'           => 'required|array',
            'apps.*.app'     => 'required|string|max:100',
            'apps.*.seconds' => 'required|integer|min:0',
        ]);

        $occurredAt = isset($validated['occurred_at'])
            ? \Illuminate\Support\Carbon::parse($validated['occurred_at'])
            : now();

        $session = PcAccessLogs::where('session_id', $validated['session_id'])
            ->where('event_type', 'time_in')
            ->first();

        foreach ($validated['apps'] as $app) {
            PcAppUsage::create([
                'session_id'  => $validated['session_id'],
                'rfid_uid'    => $session?->rfid_uid,
                'app_name'    => $app['app'],
                'seconds'     => $app['seconds'],
                'occurred_at' => $occurredAt,
            ]);
        }

        return response()->json([
            'success'  => true,
            'recorded' => count($validated['apps']),
        ], Response::HTTP_OK);
    }

    /**
     * Query the university MIS for a card.
     *
     * Returns [StudentParameters|null, reason]. A null student is always
     * paired with a human readable reason explaining why access was denied.
     */
    private function lookupStudentInMis(string $cardId): array
    {
        $timeout = (float) config('services.mis.timeout', 3);
        $url = rtrim(config('services.mis.url', 'http://localhost:5080'), '/')
            . '/api/students/' . rawurlencode($cardId);

        try {
            $response = Http::timeout($timeout)->get($url);

            if ($response->notFound()) {
                return [null, 'Card is not registered in the university MIS.'];
            }

            if ($response->successful()) {
                $data = $response->json() ?? [];

                return [[
                    'cardId'       => $data['cardId'] ?? $data['CardId'] ?? $cardId,
                    'studentNumber'=> $data['studentNumber'] ?? $data['StudentNumber'] ?? '',
                    'firstName'    => $data['firstName'] ?? $data['FirstName'] ?? '',
                    'lastName'     => $data['lastName'] ?? $data['LastName'] ?? '',
                    'middleName'   => $data['middleName'] ?? $data['MiddleName'] ?? '',
                    'course'       => $data['course'] ?? $data['Course'] ?? '',
                ], null];
            }

            return [null, 'MIS returned an unexpected response (' . $response->status() . ').'];
        } catch (\Exception $ex) {
            return [null, 'MIS is currently unavailable. Please try again.'];
        }
    }

    /**
     * Write one row to pc_access_logs in the schema the admin pages expect.
     */
    private function writeLog(array $data): void
    {
        $student   = $data['student'] ?? null;

        $snapshot = $student === null
            ? []
            : [
                'student_external_id' => $student['cardId'],
                'student_name'        => trim(($student['firstName'] ?? '') . ' ' . ($student['middleName'] ?? '') . ' ' . ($student['lastName'] ?? '')),
                'course'              => $student['course'] ?? null,
            ];

        PcAccessLogs::create(array_merge([
            'occurred_at'    => $data['occurred_at'],
            'rfid_uid'       => $data['rfid_uid'],
            'workstation_id' => $data['workstation_id'],
            'event_type'     => $data['event_type'],
            'result'         => $data['result'],
            'reason'         => $data['reason'] ?? null,
            'session_id'     => $data['session_id'] ?? null,
        ], $snapshot));
    }
}