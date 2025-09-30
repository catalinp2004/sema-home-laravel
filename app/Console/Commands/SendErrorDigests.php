<?php

namespace App\Console\Commands;

use App\Services\ErrorDigest;
use Illuminate\Console\Command;

class SendErrorDigests extends Command
{
    protected $signature = 'digest:send {--channels=vaunt-webhook,vaunt-sync}';
    protected $description = 'Send error digest emails for the given channels and clear buffers';

    public function handle(): int
    {
        $channels = explode(',', (string) $this->option('channels'));
        $digest = new ErrorDigest();
        foreach ($channels as $ch) {
            $this->line(sprintf('%s: %d item(s) queued', $ch, $digest->count($ch)));
        }
        $results = $digest->flushAll($channels);
        foreach ($results as $channel => $ok) {
            $this->line(sprintf('%s: %s', $channel, $ok ? 'sent' : 'no items'));
        }
        return 0;
    }
}
