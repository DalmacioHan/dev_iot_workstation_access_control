<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PcAccessLogs;
use App\Models\PcAppUsage;
use App\Services\MisStudentLookup;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AccessController extends Controller
{
    /**
     * Defense-in-depth denylist for obvious shell/system processes. Client-side
     * filtering is authoritative (e.g. Explorer is only tracked for real file
     * windows), so keep this list conservative.
     */
    private const SYSTEM_APP_USAGE_DENYLIST = [
        'searchhost',
        'startmenuexperiencehost',
        'shellexperiencehost',
        'textinputhost',
        'lockapp',
        'searchapp',
        'runtimebroker',
        'dwm',
        'sihost',
        'ctfmon',
        'fontdrvhost',
        'widgets',
        'widgetservice',
        'pickerhost',
        'credentialuibroker',
        'crossdeviceresume',
        'logonui',
        'securityhealthsystray',
        'systemsettingsadminflows',
    ];

    public function __construct(
        private SessionService $sessions,
        private MisStudentLookup $mis
    ) {
    }

    /**
     * Validate one RFID scan against the university MIS and log the result.
     *
     * Expected body (sent by the desktop client app):
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

        [$student, $reason] = $this->mis->lookup($cardId);

        if ($student === null) {
            $this->writeLog([
                'occurred_at'    => $occurredAt,
                'rfid_uid'       => $cardId,
                'device_id'      => $device->id,
                'event_type'     => 'denied',
                'result'         => 'denied',
                'reason'         => $reason,
            ]);

            return response()->json([
                'allowed' => false,
                'reason'  => $reason,
            ], Response::HTTP_OK);
        }

        // One student can only hold one session per workstation. Close any
        // orphan from a crash, power loss, or unacknowledged logout first.
        $this->sessions->closeOpenSessionsForDevice(
            $device->id,
            'New sign-in on same workstation',
            SessionService::ENDED_BY_SYSTEM
        );

        $sessionId = Str::uuid()->toString();

        $this->writeLog([
            'occurred_at'    => $occurredAt,
            'rfid_uid'       => $cardId,
            'device_id'      => $device->id,
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
     * Close an open session. The client calls this on lock / shutdown / timeout.
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

        $closed = $this->sessions->closeSession(
            $validated['session_id'],
            $occurredAt,
            'Session ended',
            SessionService::ENDED_BY_CLIENT
        );

        // Idempotent: a retry (or a duplicate call from the client) must not
        // create a second time_out row or fail the client.
        return response()->json([
            'success'        => true,
            'already_closed' => ! $closed,
            'message'        => $closed ? 'Session closed.' : 'Session was already closed.',
            'session_id'     => $validated['session_id'],
        ], Response::HTTP_OK);
    }

    /**
     * Record foreground app usage for one session.
     *
     * Expected body (sent by the desktop client):
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

        $recorded = 0;

        foreach ($validated['apps'] as $app) {
            $name = trim((string) ($app['app'] ?? ''));

            if ($name === '' || $this->isDeniedAppUsageName($name)) {
                continue;
            }

            PcAppUsage::create([
                'session_id'  => $validated['session_id'],
                'rfid_uid'    => $session?->rfid_uid,
                'app_name'    => $name,
                'seconds'     => $app['seconds'],
                'occurred_at' => $occurredAt,
            ]);

            $recorded++;
        }

        return response()->json([
            'success'  => true,
            'recorded' => $recorded,
        ], Response::HTTP_OK);
    }

    /**
     * Defense-in-depth: ignore pure shell/system components if reported.
     * Explorer window validity is enforced client-side, so "explorer" is allowed.
     */
    private function isDeniedAppUsageName(string $appName): bool
    {
        return in_array(mb_strtolower($appName), self::SYSTEM_APP_USAGE_DENYLIST, true);
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
                // The student number is the identity. The RFID UID is only the
                // lookup key, so never substitute it for a missing StudentNo.
                'student_external_id' => ($student['studentNumber'] ?? '') !== ''
                    ? $student['studentNumber']
                    : null,
                'student_name'        => trim(($student['firstName'] ?? '') . ' ' . ($student['middleName'] ?? '') . ' ' . ($student['lastName'] ?? '')),
                'course'              => $student['course'] ?? null,
            ];

        PcAccessLogs::create(array_merge([
            'occurred_at'    => $data['occurred_at'],
            'rfid_uid'       => $data['rfid_uid'],
            'device_id'      => $data['device_id'],
            'event_type'     => $data['event_type'],
            'result'         => $data['result'],
            'reason'         => $data['reason'] ?? null,
            'session_id'     => $data['session_id'] ?? null,
        ], $snapshot));
    }
}