<?php

return [
    'vaunt' => [
        'notify_email' => env('VAUNT_SYNC_NOTIFY_EMAIL', 'dev@krogen.ro'),
        // Error Digest configuration
        // Which cache store to use for ErrorDigest buffers (defaults to file to avoid DB table requirements)
        'digest_cache_store' => env('VAUNT_DIGEST_CACHE_STORE'),
        // Maximum recent items included in a single email
        'digest_max_items' => env('VAUNT_DIGEST_MAX_ITEMS', 50),
    ],
];
