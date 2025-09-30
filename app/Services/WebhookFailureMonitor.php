<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookFailureMonitor
{
    private string $namespace;
    private string $notifyEmail;

    public function __construct(string $namespace, array $config = [])
    {
        $this->namespace = $namespace;
        $this->notifyEmail = Arr::get($config, 'notify_email', config('sync.vaunt.notify_email', 'dev@krogen.ro'));
    }

    public function recordFailure(string $reason, array $context = []): void
    {
        Log::warning('Webhook non-2xx response recorded', [
            'namespace' => $this->namespace,
            'reason' => $reason,
            'context' => $this->truncateContext($context),
        ]);

        // Append failure to digest for periodic notifications
        try {
            (new \App\Services\ErrorDigest())->append('vaunt-webhook', [
                'reason' => $reason,
                'context' => $this->truncateContext($context),
            ]);
        } catch (\Throwable $e) {
            // As a fallback if digest append fails, attempt to notify immediately
            $this->notifyImmediate($reason, $context, $e->getMessage());
        }
    }

    private function notifyImmediate(string $reason, array $context, string $error = null): void
    {
        try {
            $to = $this->notifyEmail;
            if (!$to) {
                return;
            }

            $subject = sprintf('[Sema Home] Vaunt webhook failure: %s', $reason);
            $body = "A Vaunt webhook event failed to be recorded to digest.\n\n" .
                sprintf("Reason: %s\n", $reason) .
                "Context: " . json_encode($this->truncateContext($context)) . "\n";
            if ($error) {
                $body .= "Append error: {$error}\n";
            }

            $body .= "\nAction: Investigate logs and ensure the endpoint returns 204 to avoid Vaunt auto-disable after repeated errors.";

            Mail::raw($body, function ($message) use ($to, $subject): void {
                $message->to($to)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to send webhook failure notification (immediate fallback)', [
                'namespace' => $this->namespace,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function truncateContext(array $context): array
    {
        // Prevent huge payloads in logs/emails
        return collect($context)->map(function ($v) {
            if (is_string($v)) {
                return mb_strimwidth($v, 0, 500, '…');
            }
            if (is_array($v)) {
                return json_decode(mb_strimwidth(json_encode($v), 0, 800, '…'), true);
            }
            return $v;
        })->all();
    }
}
