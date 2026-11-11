<?php

namespace App\Http\Controllers;

use App\Services\MisSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct(private MisSettings $mis)
    {
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


        $pirTimeoutSeconds =
            (int) $settings->get(
                'pir_timeout_seconds',
                60
            );


        $staleSessionMinutes =
            (int) $settings->get(
                'stale_session_minutes',
                5
            );


        return view(
            'admin.settings.index',
            compact(
                'studentApiUrl',
                'currentEndpoint',
                'pirTimeoutSeconds',
                'staleSessionMinutes'
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
        $validated = $request->validate([
            'student_api_url' => [
                'required',
                'url',
                'max:500',
            ],

            'pir_timeout_seconds' => [
                'required',
                'integer',
                'min:5',
                'max:3600',
            ],

            'stale_session_minutes' => [
                'required',
                'integer',
                'min:1',
                'max:1440',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            DB::table('system_settings')
                ->updateOrInsert(
                    [
                        'key' => 'student_api_url',
                    ],
                    [
                        'value' =>
                            trim($validated['student_api_url']),

                        'updated_at' => now(),

                        'created_at' => now(),
                    ]
                );


            DB::table('system_settings')
                ->updateOrInsert(
                    [
                        'key' => 'pir_timeout_seconds',
                    ],
                    [
                        'value' =>
                            (string) $validated['pir_timeout_seconds'],

                        'updated_at' => now(),

                        'created_at' => now(),
                    ]
                );


            DB::table('system_settings')
                ->updateOrInsert(
                    [
                        'key' => 'stale_session_minutes',
                    ],
                    [
                        'value' =>
                            (string) $validated['stale_session_minutes'],

                        'updated_at' => now(),

                        'created_at' => now(),
                    ]
                );

        });


        return back()->with(
            'success',
            'System settings have been saved successfully.'
        );
    }
}
