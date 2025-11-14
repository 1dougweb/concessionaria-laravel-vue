<?php

return [
    'apps' => [
        [
            'id' => env('PUSHER_APP_ID', 'concessionaria'),
            'name' => env('APP_NAME', 'Concessionaria'),
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'path' => env('PUSHER_APP_PATH'),
            'capacity' => null,
            'enable_client_messages' => true,
            'enable_statistics' => env('WEBSOCKETS_ENABLE_STATS', true),
        ],
    ],

    'dashboard' => [
        'port' => env('WEBSOCKETS_DASHBOARD_PORT', 5173),
    ],

    'allowed_origins' => [
        env('APP_URL'),
        env('FRONTEND_ORIGIN'),
    ],

    'max_request_size_in_kb' => 250,

    'path' => env('PUSHER_APP_PATH', 'ws'),

    'client_message_bucket_size' => 100,

    'statistics' => [
        'model' => 'BeyondCode\\LaravelWebSockets\\Statistics\\Models\\WebSocketsStatisticsEntry',
        'interval_in_seconds' => 60,
        'delete_statistics_older_than_days' => 60,
        'perform_dns_lookup' => false,
    ],

    'ssl' => [
        'local_cert' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_CERT'),
        'local_pk' => env('LARAVEL_WEBSOCKETS_SSL_LOCAL_PK'),
        'passphrase' => env('LARAVEL_WEBSOCKETS_SSL_PASSPHRASE'),
        'verify_peer' => env('LARAVEL_WEBSOCKETS_SSL_VERIFY_PEER', false),
        'allow_self_signed' => env('LARAVEL_WEBSOCKETS_SSL_ALLOW_SELF_SIGNED', true),
    ],
];

