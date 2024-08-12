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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '647658836105-lcg9044nrbrl4kmp63g8ihnh94of90ch.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://justapartments.net/login/google/callback',
    ],
    'facebook' => [
        'client_id' => '198330469917523',
        'client_secret' => '1fed921e8361af78f2dabe3d33883ed9',
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],
    // 'github' => [
    //     'client_id' => env('GITHUB_CLIENT_ID'),
    //     'client_secret' => env('GITHUB_CLIENT_SECRET'),
    //     'redirect' => 'your_redirect_url',
    // ],

];
