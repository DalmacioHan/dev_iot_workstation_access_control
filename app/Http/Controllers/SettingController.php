<?php

namespace App\Http\Controllers;

use App\Services\ClientSettings;
use App\Services\MisSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct(
        private MisSettings $mis,
        private ClientSettings $clientSettings
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Settings Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $settings = DB::table('system_settings')
            ->pluck('value', 'key');


        // Show the value that is actually in use: the saved override when
        // present, otherwise the MIS_API_BASE_URL fallback from .env.
        $studentApiUrl = $this->mis->baseUrl();

        // Resolved endpoint with the {cardId} placeholder kept visible.
        $currentEndpoint = $this->mis->endpointFor();


        $staleSessionMinutes =
            (int) $settings->get(
                'stale_session_minutes',
                5
            );


        // Clamped client behavior values (same payload the devices receive).
        $client = $this->clientSettings->all();

        $noPresenceTimeoutSeconds = $client['no_presence_timeout_seconds'];
        $inactivityWarningSeconds = $client['inactivity_warning_seconds'];
        $shutdownGraceSeconds = $client['shutdown_grace_seconds'];
        $disableTaskManager = $client['disable_task_manager'];
        $adminPin = $client['admin_pin'] ?? '';


        return view(
            'admin.settings.index',
            compact(
                'studentApiUrl',
                'currentEndpoint',
                'staleSessionMinutes',
                'noPresenceTimeoutSeconds',
                'inactivityWarningSeconds',
                'shutdownGraceSeconds',
                'disableTaskManager',
                'adminPin'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save Settings
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        // Each tab posts its own section. A request without a section keeps
        // the original behaviour: validate and save every section at once.
        $section = $request->input('section');

        if (! in_array($section, ['client', 'mis', 'sessions'], true)) {
            $section = null;
        }

        $rules = [];

        if ($section === null || $section === 'mis') {
            $rules['student_api_url'] = [
                'required',
                'url',
                'max:500',
            ];
        }

        if ($section === null || $section === 'sessions') {
            $rules['stale_session_minutes'] = [
                'required',
                'integer',
                'min:1',
                'max:1440',
            ];
        }

        if ($section === null || $section === 'client') {
            $rules['client_no_presence_timeout_seconds'] = [
                'required',
                'integer',
                'min:' . ClientSettings::MIN_NO_PRESENCE,
                'max:' . ClientSettings::MAX_NO_PRESENCE,
            ];

            $rules['client_inactivity_warning_seconds'] = [
                'required',
                'integer',
                'min:' . ClientSettings::MIN_WARNING,
                'max:' . ClientSettings::MAX_WARNING,
            ];

            $rules['client_shutdown_grace_seconds'] = [
                'required',
                'integer',
                'min:' . ClientSettings::MIN_GRACE,
                'max:' . ClientSettings::MAX_GRACE,
            ];

            $rules['client_disable_task_manager'] = [
                'nullable',
                'boolean',
            ];

            // Server-managed admin PIN for all clients (cached offline). Blank = unset (use local PIN).
            $rules['client_admin_pin'] = [
                'nullable',
                'string',
                'max:50',
            ];
        }

        $validated = $request->validate($rules);


        $values = [];

        if (array_key_exists('student_api_url', $validated)) {
            $values['student_api_url'] = trim($validated['student_api_url']);
        }

        if (array_key_exists('stale_session_minutes', $validated)) {
            $values['stale_session_minutes'] = (string) $validated['stale_session_minutes'];
        }

        if (array_key_exists('client_no_presence_timeout_seconds', $validated)) {
            $values[ClientSettings::NO_PRESENCE_KEY] = (string) $validated['client_no_presence_timeout_seconds'];
        }

        if (array_key_exists('client_inactivity_warning_seconds', $validated)) {
            $values[ClientSettings::WARNING_KEY] = (string) $validated['client_inactivity_warning_seconds'];
        }

        if (array_key_exists('client_shutdown_grace_seconds', $validated)) {
            $values[ClientSettings::GRACE_KEY] = (string) $validated['client_shutdown_grace_seconds'];
        }

        if ($section === null || $section === 'client') {
            $values[ClientSettings::TASK_MANAGER_KEY] =
                $request->boolean('client_disable_task_manager') ? '1' : '0';

            $values[ClientSettings::ADMIN_PIN_KEY] = trim((string) $request->input('client_admin_pin', ''));
        }


        DB::transaction(function () use ($values) {

            foreach ($values as $key => $value) {

                DB::table('system_settings')
                    ->updateOrInsert(
                        [
                            'key' => $key,
                        ],
                        [
                            'value' => $value,

                            'updated_at' => now(),

                            'created_at' => now(),
                        ]
                    );

            }

        });


        $tab = $section ?? 'client';

        $messages = [
            'client' => 'Client behavior settings saved for every connected workstation client.',
            'mis' => 'MIS / UISA API settings saved.',
            'sessions' => 'Session cleanup settings saved.',
        ];


        return redirect()
            ->route('settings.index', ['tab' => $tab])
            ->with('success', $messages[$tab]);
    }
}
