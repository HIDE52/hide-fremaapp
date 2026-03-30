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

    'stripe' => [
        'key' => 'pk_test_51TFSZsIEyFonRzHxBGUhdjbNWp0ZeLdwwIaKpH7MNdCqGTJselFPFNdKx1iaZUdTQgBiLCeJOw94v41BBL7BipW400DYBtAb0S',
        'secret' => 'sk_test_51TFSZsIEyFonRzHxqclBS6kWq1jVdlNG5W4kgmmMXnvoy8rLAXPeqGK7LWfb4R5au8Er53Y2mAkPDu0UhHzc0a1s00wNqC0IzP',
    ],
];
