<?php

namespace App\Http\Middleware;

use App\Services\WebhookFailureMonitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonitorVauntWebhookResponses
{
    public function handle(Request $request, Closure $next)
    {
        $monitor = new WebhookFailureMonitor('vaunt');
        try {
            /** @var Response $response */
            $response = $next($request);

            $status = $response->getStatusCode();
            if ($status < 200 || $status >= 300) {
                $monitor->recordFailure('http-'.$status, [
                    'path' => $request->path(),
                    'status' => $status,
                ]);
            }

            return $response;
        } catch (\Throwable $e) {
            $monitor->recordFailure('exception', [
                'path' => $request->path(),
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
