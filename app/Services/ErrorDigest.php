<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ErrorDigest
{
    private string $keyPrefix = 'digest:';

    private function cache()
    {
        $store = Config::get('sync.vaunt.digest_cache_store');
        return $store ? Cache::store($store) : Cache::store(config('cache.default'));
    }

    public function append(string $channel, array $entry): void
    {
    $key = $this->key($channel);
    $cache = $this->cache();
    $items = $cache->get($key, []);
        $entry['time'] = now()->toDateTimeString();
        $items[] = $entry;
        // Keep up to 1000 items per channel to cap memory; prune older if needed
        if (count($items) > 1000) {
            $items = array_slice($items, -1000);
        }
        // Keep for an hour by default
        $cache->put($key, $items, now()->addHour());
    }

    public function count(string $channel): int
    {
        return count((array) $this->cache()->get($this->key($channel), []));
    }

    public function flush(string $channel): bool
    {
        $key = $this->key($channel);
        $cache = $this->cache();
        $items = $cache->pull($key, []);
        if (empty($items)) {
            return false;
        }

        $email = Config::get('sync.vaunt.notify_email', 'dev@krogen.ro');
        if (!$email) {
            return false;
        }

    $maxItems = (int) Config::get('sync.vaunt.digest_max_items', 50);
        $subject = $this->subjectFor($channel, count($items));
        $summary = $this->summarize($items);
        $list = array_slice($items, -$maxItems);

        $body = $summary . "\n\nRecent items (up to {$maxItems}):\n";
        foreach ($list as $i => $it) {
            $body .= sprintf("- [%s] %s | context=%s\n",
                Arr::get($it, 'time', ''),
                Arr::get($it, 'message', Arr::get($it, 'reason', 'unknown')),
                json_encode(Arr::except($it, ['time', 'message']))
            );
        }

        try {
            Mail::raw($body, function ($message) use ($email, $subject): void {
                $message->to($email)->subject($subject);
            });
            return true;
        } catch (\Throwable $e) {
            Log::error('ErrorDigest: failed to send digest', [
                'channel' => $channel,
                'error' => $e->getMessage(),
            ]);
            // Put items back so we can retry next run
            $existing = $cache->get($key, []);
            $cache->put($key, array_merge($existing, $items), now()->addMinutes(10));
            return false;
        }
    }

    public function flushAll(array $channels): array
    {
        $results = [];
        foreach ($channels as $ch) {
            $results[$ch] = $this->flush($ch);
        }
        return $results;
    }

    private function key(string $channel): string
    {
        return $this->keyPrefix . $channel;
    }

    private function subjectFor(string $channel, int $count): string
    {
        return match ($channel) {
            'vaunt-webhook' => "[Sema Home] Vaunt webhook failures digest ({$count})",
            'vaunt-sync' => "[Sema Home] Vaunt sync failures digest ({$count})",
            default => "[Sema Home] {$channel} failures digest ({$count})",
        };
    }

    private function summarize(array $items): string
    {
        $byReason = [];
        foreach ($items as $it) {
            $reason = Arr::get($it, 'reason', 'unknown');
            $byReason[$reason] = ($byReason[$reason] ?? 0) + 1;
        }
        $pairs = [];
        foreach ($byReason as $r => $c) {
            $pairs[] = "$r=$c";
        }
        return 'Summary: ' . implode(', ', $pairs);
    }
}
