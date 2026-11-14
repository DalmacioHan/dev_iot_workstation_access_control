<?php

namespace App\Services;

use App\Models\Device;
use App\Models\PcAccessLogs;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Owns every transition in the workstation session lifecycle.
 *
 * A session is "active" while its time_in row (event_type=time_in,
 * result=allowed, session_id != null) has no matching time_out row.
 * Nothing else is allowed to create time_out rows, so closing is
 * idempotent and stale sessions can always be reaped.
 */
class SessionService
{
    public const ENDED_BY_CLIENT = 'client';
    /** @deprecated Use ENDED_BY_CLIENT. Kept for legacy stored values/compat. */
    public const ENDED_BY_KIOSK = 'client';
    public const ENDED_BY_SYSTEM = 'system';
    public const ENDED_BY_ADMIN = 'admin';

    private const DEFAULT_STALE_MINUTES = 5;
    private const REAP_CACHE_KEY = 'pc-sessions:last-reap';

    /**
     * Open sessions: an allowed time_in with no time_out for the same id.
     */
    public function openSessionsQuery()
    {
        return PcAccessLogs::query()
            ->where('pc_access_logs.event_type', 'time_in')
            ->where('pc_access_logs.result', 'allowed')
            ->whereNotNull('pc_access_logs.session_id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('pc_access_logs as logout_log')
                    ->whereColumn('logout_log.session_id', 'pc_access_logs.session_id')
                    ->where('logout_log.event_type', 'time_out');
            });
    }

    /**
     * Close one session. Returns true only when a new time_out row was
     * written, so callers can tell a real close from a retry.
     */
    public function closeSession(
        string $sessionId,
        ?Carbon $occurredAt = null,
        string $reason = 'Session ended',
        string $endedBy = self::ENDED_BY_SYSTEM
    ): bool {
        $occurredAt = $occurredAt ?: now();

        return DB::transaction(function () use ($sessionId, $occurredAt, $reason, $endedBy) {
            $entry = PcAccessLogs::query()
                ->where('session_id', $sessionId)
                ->where('event_type', 'time_in')
                ->lockForUpdate()
                ->first();

            if ($entry === null) {
                return false;
            }

            $alreadyClosed = PcAccessLogs::query()
                ->where('session_id', $sessionId)
                ->where('event_type', 'time_out')
                ->exists();

            if ($alreadyClosed) {
                return false;
            }

            PcAccessLogs::create([
                'occurred_at'         => $occurredAt,
                'received_at'         => now(),
                'rfid_uid'            => $entry->rfid_uid,
                'device_id'           => $entry->device_id,
                'event_type'          => 'time_out',
                'result'              => 'allowed',
                'reason'              => $reason,
                'ended_reason'        => $reason,
                'ended_by'            => $endedBy,
                'session_id'          => $entry->session_id,
                'student_external_id' => $entry->student_external_id,
                'student_name'        => $entry->student_name,
                'course'              => $entry->course,
            ]);

            return true;
        });
    }

    /**
     * Close every open session on a device, optionally keeping one id.
     */
    public function closeOpenSessionsForDevice(
        int $deviceId,
        string $reason,
        string $endedBy,
        ?string $exceptSessionId = null
    ): int {
        $sessionIds = $this->openSessionsQuery()
            ->where('pc_access_logs.device_id', $deviceId)
            ->when($exceptSessionId, function ($query) use ($exceptSessionId) {
                $query->where('pc_access_logs.session_id', '!=', $exceptSessionId);
            })
            ->pluck('pc_access_logs.session_id');

        $closed = 0;

        foreach ($sessionIds as $sessionId) {
            if ($this->closeSession($sessionId, now(), $reason, $endedBy)) {
                $closed++;
            }
        }

        return $closed;
    }

    /**
     * Reconcile the server's view with what the client reports.
     *
     * A null session_id means the client is locked/idle. Only sessions older
     * than the grace window are closed, so a scan that is still in flight
     * cannot be killed by a heartbeat that was queued a moment earlier.
     */
    public function reconcileFromHeartbeat(Device $device, ?string $sessionId): void
    {
        if (!empty($sessionId)) {
            $this->closeOpenSessionsForDevice(
                $device->id,
                'Device reported a different session',
                self::ENDED_BY_SYSTEM,
                $sessionId
            );

            return;
        }

        $cutoff = now()->subSeconds(90);

        $sessionIds = $this->openSessionsQuery()
            ->where('pc_access_logs.device_id', $device->id)
            ->where('pc_access_logs.occurred_at', '<', $cutoff)
            ->pluck('pc_access_logs.session_id');

        foreach ($sessionIds as $sessionId) {
            $this->closeSession(
                $sessionId,
                now(),
                'Client reported no active session',
                self::ENDED_BY_SYSTEM
            );
        }
    }

    /**
     * Close sessions on workstations that stopped checking in.
     *
     * Runs lazily and at most once every 30 seconds; the deployment scripts
     * do not start the Laravel scheduler.
     */
    public function reapStaleSessions(): int
    {
        if (!Cache::add(self::REAP_CACHE_KEY, true, 30)) {
            return 0;
        }

        $minutes = $this->staleMinutes();
        $cutoff = now()->subMinutes($minutes);

        $sessionIds = $this->openSessionsQuery()
            ->join('devices', 'devices.id', '=', 'pc_access_logs.device_id')
            ->where(function ($query) use ($cutoff) {
                $query->whereNull('devices.last_seen_at')
                    ->orWhere('devices.last_seen_at', '<', $cutoff);
            })
            ->where('pc_access_logs.occurred_at', '<', $cutoff)
            ->pluck('pc_access_logs.session_id');

        $closed = 0;

        foreach ($sessionIds as $sessionId) {
            $reason = "No heartbeat for {$minutes} minute" . ($minutes === 1 ? '' : 's')
                . ' / improper logout';

            if ($this->closeSession($sessionId, now(), $reason, self::ENDED_BY_SYSTEM)) {
                $closed++;
            }
        }

        return $closed;
    }

    /**
     * Configured stale threshold, clamped to a safe range.
     */
    public function staleMinutes(): int
    {
        $value = DB::table('system_settings')
            ->where('key', 'stale_session_minutes')
            ->value('value');

        if ($value === null || $value === '') {
            return self::DEFAULT_STALE_MINUTES;
        }

        return max(1, min(1440, (int) $value));
    }
}
