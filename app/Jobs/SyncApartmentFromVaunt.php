<?php

namespace App\Jobs;

use App\Models\Apartment;
use App\Models\ApartmentImage;
use App\Models\Floor;
use App\Services\ErrorDigest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SyncApartmentFromVaunt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 25; // stay under webhook's 30s; job itself can be retried
    // Increase allowed attempts so rate-limiter releases don't quickly exhaust retries.
    // Vaunt rate limiting may release jobs many times; set a large tries value.
    public int $tries = 120;

    // Backoff used when the job is released/fails to avoid tight retry loops.
    public int $backoff = 60; // seconds

    public function __construct(public int $propertyId)
    {
    }

    /**
     * Throttle jobs for Vaunt webhooks using the named limiter.
     * This ensures we respect Vaunt's rate limits (default 60/min) across workers.
     *
     * @return array<int, \Illuminate\Queue\Middleware\RateLimited>
     */
    public function middleware(): array
    {
        return [new RateLimited('webhooks')];
    }

    public function handle(): void
    {
        $base = rtrim(Config::get('vaunt.base_url', 'https://api.vaunt.ro/v1'), '/');
        $uuid = Config::get('vaunt.agency_uuid');
        $token = Config::get('vaunt.api_token');

        if (!$uuid || !$token) {
            Log::error('Vaunt API creds missing');
            return;
        }

        $url = "$base/external/properties/{$this->propertyId}";
        $response = Http::withHeaders([
            'agency-uuid' => $uuid,
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            // Use configured accept language for Vaunt API; default to Romanian to match provider floor names
            'Accept-Language' => Config::get('vaunt.accept_language', 'ro'),
        ])->timeout($this->timeout)->get($url);

        if (!$response->successful()) {
            Log::warning('Vaunt property fetch failed', [
                'id' => $this->propertyId,
                'status' => $response->status(),
                'body' => Str::limit($response->body(), 500),
            ]);
            $this->notifyFailure('fetch-failed', [
                'status' => $response->status(),
                'body' => Str::limit($response->body(), 300),
            ]);
            return;
        }

        $data = $response->json();

        // Use provider floor_value directly and match case-insensitively against local floors
        $floorNameRaw = $data['floor_value'] ?? null;
        if (!$floorNameRaw) {
            Log::warning('Property missing floor_value', ['id' => $this->propertyId]);
            $this->notifyFailure('missing-floor-value');
            return;
        }

        $query = Floor::query()->whereRaw('LOWER(name) = ?', [mb_strtolower($floorNameRaw)]);
        if ($buildingId = Config::get('vaunt.default_building_id')) {
            $query->where('building_id', $buildingId);
        }
        $floor = $query->first();
        if (!$floor) {
            Log::warning('Floor not found for property', ['id' => $this->propertyId, 'floor_value' => $floorNameRaw]);
            $this->notifyFailure('floor-not-found', ['floor_value' => $floorNameRaw]);
            return;
        }

        // Upsert apartment and images in a transaction to avoid partial updates.
        // Preserve existing `g_content` if the apartment already exists; new apartments should have null `g_content`.
        $existing = Apartment::query()->find((int) ($data['id'] ?? 0));
        $gContentValue = $existing ? $existing->g_content : null;

        // Sanitize enums to avoid DB enum constraint violations
        $builtState = $this->safeEnum($data['built_state'] ?? null, ['under_construction', 'project', 'finished', 'coming_soon'], 'under_construction', 'built_state');
        // Accept new provider value 'hold' as a valid availability
        $availability = $this->safeEnum($data['availability'] ?? null, ['available', 'unavailable', 'sold', 'let', 'reserved', 'hold'], 'available', 'availability');
        $homeType = $this->safeEnum($data['home_type'] ?? null, ['apartment', 'studio', '1bedroom', 'penthouse', 'duplex'], 'apartment', 'home_type');
        $kitchenType = $this->safeEnum($data['kitchen_type'] ?? null, ['opened', 'closed'], null, 'kitchen_type');

        // Coerce array-like fields to arrays
        $selected_orientations = $this->coerceArray($data['selected_orientations'] ?? []);
        $utility_values = $this->coerceArray($data['utility_values'] ?? []);
        $facility_values = $this->coerceArray($data['facility_values'] ?? []);
        $finish_values = $this->coerceArray($data['finish_values'] ?? []);
        $service_values = $this->coerceArray($data['service_values'] ?? []);
        $zone_detail_values = $this->coerceArray($data['zone_detail_values'] ?? []);
        $videos = $this->coerceArray($data['videos'] ?? []);
        $documents = $this->coerceArray($data['documents'] ?? []);

        try {
            DB::transaction(function () use ($data, $floor, $gContentValue, $builtState, $availability, $homeType, $kitchenType, $selected_orientations, $utility_values, $facility_values, $finish_values, $service_values, $zone_detail_values, $videos, $documents, &$apartment) {
                $apartment = Apartment::query()->updateOrCreate(
                ['id' => (int) $data['id']],
                [
                'floor_id' => $floor->id,
                'type_name' => $data['type_name'] ?? null,
                'selected_orientations' => $selected_orientations,
                'friendly_id' => $data['friendly_id'],
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'website_latitude' => $data['website_latitude'] ?? 0,
                'website_longitude' => $data['website_longitude'] ?? 0,
                'website_address' => $data['website_address'] ?? '',
                'room_count' => $data['room_count'] ?? 0,
                'usable_size_sqm' => $data['usable_size_sqm'] ?? 0,
                'built_size_sqm' => $data['built_size_sqm'] ?? null,
                'year_built' => $data['year_built'] ?? null,
                'built_state' => $builtState,
                'bathroom_count' => $data['bathroom_count'] ?? 0,
                'floor_count' => $data['floor_count'] ?? 0,
                'sale_price' => $data['sale_price'] ?? 0,
                'promo_sale_price' => $data['promo_sale_price'] ?? null,
                'price_per_sqm' => $data['price_per_sqm'] ?? null,
                'floor_value' => $data['floor_value'] ?? '',
                'home_type' => $homeType,
                'layout_value' => $data['layout_value'] ?? null,
                'confort_value' => $data['confort_value'] ?? null,
                'balcony_size_sqm' => $data['balcony_size_sqm'] ?? null,
                'total_size_sqm' => $data['total_size_sqm'] ?? null,
                'garden_size_sqm' => $data['garden_size_sqm'] ?? null,
                'availability' => $availability,
                'kitchen_type' => $kitchenType,
                'number' => $data['number'] ?? null,
                'utility_values' => $utility_values,
                'facility_values' => $facility_values,
                'finish_values' => $finish_values,
                'service_values' => $service_values,
                'zone_detail_values' => $zone_detail_values,
                'balcony_count' => $data['balcony_count'] ?? null,
                'kitchen_count' => $data['kitchen_count'] ?? null,
                'garage_count' => $data['garage_count'] ?? null,
                'parking_spots_count' => $data['parking_spots_count'] ?? null,
                'terrace_count' => $data['terrace_count'] ?? null,
                'terrace_size_sqm' => $data['terrace_size_sqm'] ?? null,
                'virtual_tour_url' => $data['virtual_tour_url'] ?? null,
                'videos' => $videos,
                'energy_efficiency_class' => $data['energy_efficiency_class'] ?? null,
                'api_created_at' => $data['created_at'] ?? null,
                'api_updated_at' => $data['updated_at'] ?? null,
                'website_published' => (bool) ($data['website_published'] ?? false),
                'promo' => (bool) ($data['promo'] ?? false),
                'zone' => $data['zone'] ?? null,
                'agent_id' => $data['agent']['id'] ?? null,
                'documents' => $documents,
                'project_id' => $data['project']['id'] ?? 0,
                'client_id' => $data['client']['id'] ?? null,
                // `g_content` is local SVG g-element content used for overlays. It is not provided by the API
                // and must be maintained locally. Preserve existing value on updates; set to null for new records.
                'g_content' => $gContentValue,
            ]
                );

                // Images sync (upsert present, remove stale)
                $images = is_array($data['images'] ?? null) ? $data['images'] : [];
                $seen = [];
                foreach ($images as $idx => $img) {
                    if (!is_array($img) || !isset($img['id'])) {
                        continue;
                    }
                    $imgId = (int) $img['id'];
                    $seen[] = $imgId;
                    ApartmentImage::updateOrCreate(
                        ['id' => $imgId],
                        [
                            'apartment_id' => $apartment->id,
                            'url' => $img['url'] ?? '',
                            'width_320_url' => $img['width_320_url'] ?? ($img['url'] ?? ''),
                            'width_560_url' => $img['width_560_url'] ?? ($img['url'] ?? ''),
                            'title' => $img['title'] ?? null,
                            'description' => $img['description'] ?? null,
                            'image_processing' => (bool) ($img['image_processing'] ?? false),
                            'api_created_at' => $img['created_at'] ?? null,
                            'sort_order' => $idx,
                        ]
                    );
                }

                // Optionally prune stale images not present anymore
                ApartmentImage::where('apartment_id', $apartment->id)
                    ->whereNotIn('id', $seen)
                    ->delete();
            });
    } catch (\Throwable $e) {
            Log::error('Vaunt sync unexpected error', [
                'property_id' => $this->propertyId,
                'message' => $e->getMessage(),
                'trace' => Str::limit($e->getTraceAsString(), 2000),
            ]);
            $this->notifyFailure('exception', ['error' => $e->getMessage()]);
            throw $e; // preserve job retry/failure semantics
        }
    }

    private function notifyFailure(string $reason, array $context = []): void
    {
        try {
            (new ErrorDigest())->append('vaunt-sync', [
                'reason' => $reason,
                'message' => 'Vaunt apartment sync failed',
                'property_id' => $this->propertyId,
                'context' => $context,
            ]);
        } catch (\Throwable $e) {
            // Fallback: attempt to email immediately if digest append fails
            try {
                $to = Config::get('sync.vaunt.notify_email', 'dev@krogen.ro');
                if ($to) {
                    $subject = sprintf('[Sema Home] Vaunt sync failure: %s (id: %d)', $reason, $this->propertyId);
                    $body = "A Vaunt apartment sync failed.\n\n" .
                        "Property ID: {$this->propertyId}\n" .
                        "Reason: {$reason}\n" .
                        "Context: " . json_encode($context) . "\n";
                    Mail::raw($body, function ($message) use ($to, $subject): void {
                        $message->to($to)->subject($subject);
                    });
                }
            } catch (\Throwable $e2) {
                Log::error('Failed to send sync failure email (fallback)', [
                    'reason' => $reason,
                    'error' => $e2->getMessage(),
                ]);
            }
        }
    }

    /**
     * Ensure the value is an array; return [] when missing or malformed.
     */
    private function coerceArray(mixed $value): array
    {
        return is_array($value) ? $value : [];
    }

    /**
     * Whitelist enum values to avoid DB enum constraint violations.
     * Logs when a fallback is applied.
     */
    private function safeEnum($value, array $allowed, $default, string $field)
    {
        if ($value === null || $value === '') {
            return $default;
        }
        if (in_array($value, $allowed, true)) {
            return $value;
        }
        Log::warning('Sync enum fallback applied', [
            'field' => $field,
            'value_received' => $value,
            'fallback_used' => $default,
            'property_id' => $this->propertyId,
        ]);
        $this->notifyFailure('warning:enum-fallback-used', [
            'field' => $field,
            'value_received' => $value,
            'fallback_used' => $default,
        ]);
        return $default;
    }
}
