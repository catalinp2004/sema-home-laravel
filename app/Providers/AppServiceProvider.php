<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        // Register a global limiter for Vaunt webhook processing.
        // Vaunt enforces a 60 requests per minute limit; make this configurable via VAUNT_RATE_LIMIT.
        $limit = (int) env('VAUNT_RATE_LIMIT', 60);
        RateLimiter::for('webhooks', function () use ($limit) {
            return Limit::perMinute($limit)->by('webhooks');
        });

        // For older MySQL/MariaDB on shared hosting, restrict default string length
        // so unique indexes on utf8mb4 columns (e.g., users.email) do not exceed index
        // byte limits (767/1000 bytes depending on engine/version).
        Schema::defaultStringLength(191);
    }
}
