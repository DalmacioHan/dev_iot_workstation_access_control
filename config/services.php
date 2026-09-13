<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | MIS (University Student Information) API
    |--------------------------------------------------------------------------
    |
    | The kiosk desktop app validates RFID cards through this Laravel backend,
    | which in turn proxies the student lookup to the university MIS. Today it
    | points at the simulated LibraryApi; swap MIS_API_BASE_URL to the real
    | UISA/MIS later without touching any other code.
    |
    */

    'mis' => [
        'url' => env('MIS_API_BASE_URL', 'http://localhost:5080'),
        'timeout' => env('MIS_API_TIMEOUT', 3),
    ],

];
