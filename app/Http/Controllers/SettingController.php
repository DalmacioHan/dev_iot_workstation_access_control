<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Settings Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $settings = DB::table('system_settings')
            ->pluck('value', 'key');


        $studentApiUrl =
            $settings->get('student_api_url', '');


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
                            $validated['student_api_url'],

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
