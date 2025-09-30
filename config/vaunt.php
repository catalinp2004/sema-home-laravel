<?php

return [
    'base_url' => env('VAUNT_BASE_URL', 'https://api.vaunt.ro/v1'),
    'agency_uuid' => env('VAUNT_AGENCY_UUID'),
    'api_token' => env('VAUNT_API_TOKEN'),

    // Preferred accept-language to use when calling Vaunt API. Default to Romanian.
    'accept_language' => env('VAUNT_ACCEPT_LANGUAGE', 'ro'),

    // Local building to attach apartments to when resolving floors by name.
    // If null, floors are resolved by name globally.
    'default_building_id' => env('APARTMENTS_DEFAULT_BUILDING_ID'),

    // Webhook security: whether to strictly require matching agency UUID header
    'enforce_agency_uuid' => env('VAUNT_ENFORCE_AGENCY_UUID', true),
];
