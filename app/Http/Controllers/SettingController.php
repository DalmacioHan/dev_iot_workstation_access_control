<?php

namespace App\Http\Controllers;

use App\Services\KioskSettings;
use App\Services\MisSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct(
        private MisSettings $mis,
        private KioskSettings $kiosk
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


        // Clamped kiosk behavior values (same payload the devices receive).
        $kiosk = $this->kiosk->all();

        $noPresenceTimeoutSeconds = $kiosk['no_presence_timeout_seconds'];
        $inactivityWarningSeconds = $kiosk['inactivity_warning_seconds'];
        $shutdownGraceSeconds = $kiosk['shutdown_grace_seconds'];
        $disableTaskManager = $kiosk['disable_task_manager'];


        return view(
            'admin.settings.index',
            compact(
                'studentApiUrl',
                'currentEndpoint',
                'staleSessionMinutes',
                'noPresenceTimeoutSeconds',
                'inactivityWarningSeconds',
                'shutdownGraceSeconds',
                'disableTaskManager'
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

        if (! in_array($section, ['kiosk', 'mis', 'sessions'], true)) {
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

        if ($section === null || $section === 'kiosk') {
            $rules['kiosk_no_presence_timeout_seconds'] = [
                'required',
                'integer',
                'min:' . KioskSettings::MIN_NO_PRESENCE,
                'max:' . KioskSettings::MAX_NO_PRESENCE,
            ];

            $rules['kiosk_inactivity_warning_seconds'] = [
                'required',
                'integer',
                'min:' . KioskSettings::MIN_WARNING,
                'max:' . KioskSettings::MAX_WARNING,
            ];

            $rules['kiosk_shutdown_grace_seconds'] = [
                'required',
                'integer',
                'min:' . KioskSettings::MIN_GRACE,
                'max:' . KioskSettings::MAX_GRACE,
            ];

            $rules['kiosk_disable_task_manager'] = [
                'nullable',
                'boolean',
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

        if (array_key_exists('kiosk_no_presence_timeout_seconds', $validated)) {
            $values[KioskSettings::NO_PRESENCE_KEY] = (string) $validated['kiosk_no_presence_timeout_seconds'];
        }

        if (array_key_exists('kiosk_inactivity_warning_seconds', $validated)) {
            $values[KioskSettings::WARNING_KEY] = (string) $validated['kiosk_inactivity_warning_seconds'];
        }

        if (array_key_exists('kiosk_shutdown_grace_seconds', $validated)) {
            $values[KioskSettings::GRACE_KEY] = (string) $validated['kiosk_shutdown_grace_seconds'];
        }

        if ($section === null || $section === 'kiosk') {
            $values[KioskSettings::TASK_MANAGER_KEY] =
                $request->boolean('kiosk_disable_task_manager') ? '1' : '0';
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


        $tab = $section ?? 'kiosk';

        $messages = [
            'kiosk' => 'Kiosk behavior settings saved for every connected kiosk.',
            'mis' => 'MIS / UISA API settings saved.',
            'sessions' => 'Session cleanup settings saved.',
        ];


        return redirect()
            ->route('settings.index', ['tab' => $tab])
            ->with('success', $messages[$tab]);
    }
}
