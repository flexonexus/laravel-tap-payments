<?php

return [
    'merchant_id' => env('TAP_MERCHANT_ID', ''),
    'secret_key' => env('TAP_SECRET_KEY', ''),     // Bearer key for API calls
    'public_key' => env('TAP_PUBLIC_KEY', ''),     // For frontend if needed
    'webhook_secret' => env('TAP_WEBHOOK_SECRET', ''), // For signature/HMAC verification

    // Switch between sandbox and production
    'mode' => env('TAP_MODE', 'sandbox'), // sandbox|live

    'endpoints' => [
        'sandbox' => 'https://api.tap.company/v2',
        'live'    => 'https://api.tap.company/v2'
    ],

    // Time tolerance for webhook timestamps (seconds)
    'tolerance' => 300,
];
