<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Resolves the MIS / Library API connection settings at runtime.
 *
 * The Laravel admin settings page stores an override in `system_settings`.
 * When a key is absent or blank, the value from config/services.php
 * (MIS_API_* environment variables) is used, so existing deployments keep
 * working without editing .env or re-configuring anything.
 */
class MisSettings
{
    public const URL_KEY = 'student_api_url';
    public const PATH_KEY = 'student_api_path';

    /** @var array<string, string>|null */
    private ?array $cache = null;

    /**
     * Base URL, without a trailing slash.
     */
    public function baseUrl(): string
    {
        $value = $this->setting(self::URL_KEY);

        if ($value === '') {
            $value = (string) config('services.mis.url', 'http://localhost:5080');
        }

        return rtrim($value, '/');
    }

    /**
     * Student lookup path. {cardId} / {cardNo} are replaced at request time.
     */
    public function studentPath(): string
    {
        $value = $this->setting(self::PATH_KEY);

        if ($value === '') {
            $value = (string) config('services.mis.student_path', '/api/students/{cardId}');
        }

        return $value;
    }

    public function apiKey(): string
    {
        return (string) config('services.mis.key', '');
    }

    public function timeout(): float
    {
        return (float) config('services.mis.timeout', 3);
    }

    /**
     * The endpoint currently in use, for display on the settings page.
     * With no card supplied it keeps the {cardId} placeholder visible.
     */
    public function endpointFor(string $cardId = '{cardId}'): string
    {
        $path = str_replace(
            ['{cardId}', '{cardNo}'],
            $cardId,
            $this->studentPath()
        );

        return $this->baseUrl() . '/' . ltrim($path, '/');
    }

    private function setting(string $key): string
    {
        if ($this->cache === null) {
            $this->cache = DB::table('system_settings')
                ->whereIn('key', [self::URL_KEY, self::PATH_KEY])
                ->pluck('value', 'key')
                ->map(fn ($value) => trim((string) $value))
                ->all();
        }

        return $this->cache[$key] ?? '';
    }
}
