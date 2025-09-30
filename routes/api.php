<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhooks\VauntWebhookController;

// Webhook endpoint: lives under API routes to avoid CSRF protection
Route::post('/webhooks/vaunt/properties', VauntWebhookController::class)->name('api.webhooks.vaunt.properties');
