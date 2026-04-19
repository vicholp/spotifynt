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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'covers_service_url' => env('COVERS_SERVICE_URL', 'http://covers:8000/'),
    'mb_service_url' => env('MB_SERVICE_URL', 'http://mb:8000/'),
    'tagger_service_url' => env('TAGGER_SERVICE_URL', 'http://tagger:8000/'),
    'alpha_plugin_url' => env('ALPHA_PLUGIN_URL', 'http://alpha-plugin:8000/'),
    'rec_service_url' => env('REC_SERVICE_URL', 'http://rec:8000/'),
    'lrclib_service_url' => env('LRCLIB_SERVICE_URL', 'https://lrclib.net/'),
];
