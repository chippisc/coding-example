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

    'schulcampus_api' => [
        'base_url' => env('SCHULCAMPUS_API_BASE_URL'),
        'client_id' => env('SCHULCAMPUT_CLIENT_ID'),
        'client_secret' => env('SCHULCAMPUT_CLIENT_SECRET'),
        'token_path' => env('SCHULCAMPUS_TOKEN_PATH'),
        'users_path' => env('SCHULCAMPUS_USERS_PATH'),
        'users_url' => env('SCHULCAMPUS_API_BASE_URL').env('SCHULCAMPUS_USERS_PATH'),
        'token_url' => env('SCHULCAMPUS_API_BASE_URL').env('SCHULCAMPUS_TOKEN_PATH'),
    ],
];
