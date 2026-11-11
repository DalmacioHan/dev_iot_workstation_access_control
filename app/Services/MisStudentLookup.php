<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Looks up one RFID card in the university MIS.
 *
 * The simulated LibraryApi now answers with the official UISA column names
 * (StudentNo, LastName, FirstName, MiddleName, Sex, Course, CardNo). The
 * older camelCase names are still accepted so existing deployments keep
 * working while the real UISA endpoint is wired in.
 */
class MisStudentLookup
{
    /**
     * @return array{0: array<string, string>|null, 1: string|null}
     *         [student, reason]. A null student always has a reason.
     */
    public function lookup(string $cardId): array
    {
        $timeout = (float) config('services.mis.timeout', 3);
        $base = rtrim((string) config('services.mis.url', 'http://localhost:5080'), '/');
        $path = (string) config('services.mis.student_path', '/api/students/{cardId}');
        $path = str_replace(
            ['{cardId}', '{cardNo}'],
            rawurlencode($cardId),
            $path
        );

        $url = $base . '/' . ltrim($path, '/');

        try {
            $request = Http::timeout($timeout);

            $misKey = (string) config('services.mis.key');
            if ($misKey !== '') {
                $request = $request->withHeaders(['X-API-Key' => $misKey]);
            }

            $response = $request->get($url);

            if ($response->notFound()) {
                return [null, 'Card is not registered in the university MIS.'];
            }

            if ($response->unauthorized()) {
                return [null, 'MIS rejected the API key.'];
            }

            if (! $response->successful()) {
                return [null, 'MIS returned an unexpected response (' . $response->status() . ').'];
            }

            $data = $this->unwrap($response->json() ?? []);

            if (! is_array($data)) {
                return [null, 'MIS returned an unexpected response.'];
            }

            return [[
                'cardId'         => (string) ($this->pick($data, ['CardNo', 'cardNo', 'cardId', 'CardId']) ?? $cardId),
                'studentNumber'  => (string) ($this->pick($data, ['StudentNo', 'studentNo', 'studentNumber', 'StudentNumber']) ?? ''),
                'firstName'      => (string) ($this->pick($data, ['FirstName', 'firstName']) ?? ''),
                'lastName'       => (string) ($this->pick($data, ['LastName', 'lastName']) ?? ''),
                'middleName'     => (string) ($this->pick($data, ['MiddleName', 'middleName']) ?? ''),
                'course'         => (string) ($this->pick($data, ['Course', 'course']) ?? ''),
            ], null];
        } catch (\Throwable $ex) {
            return [null, 'MIS is currently unavailable. Please try again.'];
        }
    }

    /**
     * Accept either a plain object, a {data: {...}} / {student: {...}} wrapper,
     * or a one-item list. Real MIS gateways often wrap their payload.
     *
     * @param  array<mixed>  $data
     * @return array<mixed>
     */
    private function unwrap(array $data): array
    {
        if (isset($data['data']) && is_array($data['data'])) {
            return $data['data'];
        }

        if (isset($data['student']) && is_array($data['student'])) {
            return $data['student'];
        }

        if ($data !== [] && array_is_list($data) && is_array($data[0] ?? null)) {
            return $data[0];
        }

        return $data;
    }

    /**
     * @param  array<mixed>  $data
     * @param  list<string>  $keys
     */
    private function pick(array $data, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                return $data[$key];
            }
        }

        return null;
    }
}
