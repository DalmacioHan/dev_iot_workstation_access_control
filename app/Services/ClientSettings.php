<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Resolves the workstation client power / idle settings that Laravel pushes to
 * every desktop client through GET /api/device/config.
 *
 * Values live in the shared `system_settings` key/value table (no migration
 * needed). Anything missing or out of range falls back to the safe defaults
 * below, so a bad row can never break a client.
 */
class ClientSettings
{
    public const NO_PRESENCE_KEY = 'client_no_presence_timeout_seconds';
    public const WARNING_KEY = 'client_inactivity_warning_seconds';
    public const GRACE_KEY = 'client_shutdown_grace_seconds';
    public const TASK_MANAGER_KEY = 'client_disable_task_manager';
    public const ADMIN_PIN_KEY = 'client_admin_pin';

    public const LEGACY_NO_PRESENCE_KEY = 'kiosk_no_presence_timeout_seconds';
    public const LEGACY_WARNING_KEY = 'kiosk_inactivity_warning_seconds';
    public const LEGACY_GRACE_KEY = 'kiosk_shutdown_grace_seconds';
    public const LEGACY_TASK_MANAGER_KEY = 'kiosk_disable_task_manager';
    public const LEGACY_ADMIN_PIN_KEY = 'kiosk_admin_pin';

    public const DEFAULT_NO_PRESENCE = 300;
    public const DEFAULT_WARNING = 10;
    public const DEFAULT_GRACE = 90;
    public const DEFAULT_TASK_MANAGER = false;

    public const MIN_NO_PRESENCE = 30;
    public const MAX_NO_PRESENCE = 86400;
    public const MIN_WARNING = 3;
    public const MAX_WARNING = 120;
    public const MIN_GRACE = 5;
    public const MAX_GRACE = 3600;

    /** @var array<string, string>|null */
    private ?array $cache = null;

    /**
     * The config every client receives, already clamped to its safe range.
     *
     * @return array<string, int|bool|string>
     */
    public function all(): array
    {
        return [
            'no_presence_timeout_seconds' => $this->int(
                self::NO_PRESENCE_KEY,
                self::LEGACY_NO_PRESENCE_KEY,
                self::DEFAULT_NO_PRESENCE,
                self::MIN_NO_PRESENCE,
                self::MAX_NO_PRESENCE
            ),
            'inactivity_warning_seconds' => $this->int(
                self::WARNING_KEY,
                self::LEGACY_WARNING_KEY,
                self::DEFAULT_WARNING,
                self::MIN_WARNING,
                self::MAX_WARNING
            ),
            'shutdown_grace_seconds' => $this->int(
                self::GRACE_KEY,
                self::LEGACY_GRACE_KEY,
                self::DEFAULT_GRACE,
                self::MIN_GRACE,
                self::MAX_GRACE
            ),
            'disable_task_manager' => $this->bool(
                self::TASK_MANAGER_KEY,
                self::LEGACY_TASK_MANAGER_KEY,
                self::DEFAULT_TASK_MANAGER
            ),
            // Server-managed admin PIN (cached by clients for offline use). Empty = not set.
            'admin_pin' => $this->setting(self::ADMIN_PIN_KEY, self::LEGACY_ADMIN_PIN_KEY),
        ];
    }

    /**
     * Timestamp of the newest client setting, or "defaults" when none has
     * ever been saved. The client only uses this for logging / display.
     */
    public function version(): string
    {
        $latest = DB::table('system_settings')
            ->whereIn('key', self::allKeys())
            ->max('updated_at');

        return $latest ? (string) $latest : 'defaults';
    }

    /**
     * Canonical keys written by the server.
     *
     * @return array<int, string>
     */
    public static function keys(): array
    {
        return [
            self::NO_PRESENCE_KEY,
            self::WARNING_KEY,
            self::GRACE_KEY,
            self::TASK_MANAGER_KEY,
            self::ADMIN_PIN_KEY,
        ];
    }

    /**
     * Canonical and legacy keys consulted for reads/migration compatibility.
     *
     * @return array<int, string>
     */
    public static function allKeys(): array
    {
        return [
            self::NO_PRESENCE_KEY,
            self::WARNING_KEY,
            self::GRACE_KEY,
            self::TASK_MANAGER_KEY,
            self::ADMIN_PIN_KEY,
            self::LEGACY_NO_PRESENCE_KEY,
            self::LEGACY_WARNING_KEY,
            self::LEGACY_GRACE_KEY,
            self::LEGACY_TASK_MANAGER_KEY,
            self::LEGACY_ADMIN_PIN_KEY,
        ];
    }

    private function int(string $key, string $legacyKey, int $default, int $min, int $max): int
    {
        $raw = $this->setting($key, $legacyKey);

        if ($raw === '' || !is_numeric($raw)) {
            return $default;
        }

        return max($min, min($max, (int) $raw));
    }

    private function bool(string $key, string $legacyKey, bool $default): bool
    {
        $raw = strtolower($this->setting($key, $legacyKey));

        if ($raw === '') {
            return $default;
        }

        return in_array($raw, ['1', 'true', 'yes', 'on'], true);
    }

    private function setting(string $key, ?string $legacyKey = null): string
    {
        if ($this->cache === null) {
            $this->cache = DB::table('system_settings')
                ->whereIn('key', self::allKeys())
                ->pluck('value', 'key')
                ->map(fn ($value) => trim((string) $value))
                ->all();
        }

        if (array_key_exists($key, $this->cache) && $this->cache[$key] !== '') {
            return $this->cache[$key];
        }

        if ($legacyKey !== null && array_key_exists($legacyKey, $this->cache)) {
            return $this->cache[$legacyKey];
        }

        return $this->cache[$key] ?? '';
    }
}
