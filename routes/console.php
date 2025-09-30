<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('digest:send')->everyTenMinutes()->description('Send error digests');

// Process the queue every minute in a short-lived worker; ideal for shared hosting
Schedule::command('queue:work --stop-when-empty --sleep=3 --tries=3')
    ->everyMinute()
    ->withoutOverlapping()
    ->description('Process queued jobs');
