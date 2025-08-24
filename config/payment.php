<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment provider that will be used
    | when no specific provider is requested.
    |
    */
    'default' => env('PAYMENT_DEFAULT_PROVIDER', 'touchpoint'),

    /*
    |--------------------------------------------------------------------------
    | InTouch Services Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for InTouch services (TouchPoint)
    |
    */
    'intouch' => [
        'api_key' => env('INTOUCH_API_KEY'),
        'webhook_secret' => env('INTOUCH_WEBHOOK_SECRET'),
        'base_uri' => env('INTOUCH_BASE_URI', 'https://api.touchpoint.intouchgroup.net/v1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayTech Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayTech payment provider
    |
    */
    'paytech' => [
        'base_url' => env('PAYTECH_BASE_URL', 'https://paytech.sn/api/payment'),
        'api_key' => env('PAYTECH_API_KEY'),
        'secret_key' => env('PAYTECH_SECRET_KEY'),
        'environment' => env('PAYTECH_ENVIRONMENT', 'test'), // test or prod
    ],

    /*
    |--------------------------------------------------------------------------
    | PayDunya Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayDunya payment provider
    |
    */
    'paydunya' => [
        'base_url' => env('PAYDUNYA_BASE_URL', 'https://app.paydunya.com/api/v1'),
        'api_key' => env('PAYDUNYA_API_KEY'),
        'secret_key' => env('PAYDUNYA_SECRET_KEY'),
        'environment' => env('PAYDUNYA_ENVIRONMENT', 'test'), // test or live
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    |
    | General payment configuration
    |
    */
    'currency' => env('PAYMENT_CURRENCY', 'XOF'),
    'transaction_timeout' => env('PAYMENT_TRANSACTION_TIMEOUT', 30), // minutes
    'max_retry_attempts' => env('PAYMENT_MAX_RETRY_ATTEMPTS', 3),
    
    /*
    |--------------------------------------------------------------------------
    | Frontend URLs
    |--------------------------------------------------------------------------
    |
    | URLs for payment callbacks and redirects
    |
    */
    'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000'),
    'success_url' => env('PAYMENT_SUCCESS_URL', '/payment/success'),
    'cancel_url' => env('PAYMENT_CANCEL_URL', '/payment/cancel'),
    'error_url' => env('PAYMENT_ERROR_URL', '/payment/error'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Security
    |--------------------------------------------------------------------------
    |
    | Security settings for payment webhooks
    |
    */
    'webhook_timeout' => env('PAYMENT_WEBHOOK_TIMEOUT', 10), // seconds
    'verify_ssl' => env('PAYMENT_VERIFY_SSL', true),
    
    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Payment logging configuration
    |
    */
    'log_payments' => env('PAYMENT_LOG_ENABLED', true),
    'log_webhooks' => env('PAYMENT_LOG_WEBHOOKS', true),
    'log_level' => env('PAYMENT_LOG_LEVEL', 'info'),
];
