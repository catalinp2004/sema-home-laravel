<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\SyncApartmentFromVaunt;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VauntWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $enforce = (bool) Config::get('vaunt.enforce_agency_uuid', true);
        $expectedUuid = Config::get('vaunt.agency_uuid');
        $incomingUuid = $request->header('agency-uuid');

        if ($enforce && (!$incomingUuid || !$expectedUuid || $incomingUuid !== $expectedUuid)) {
            Log::warning('Vaunt webhook rejected due to missing/mismatched agency-uuid', [
                'incoming' => $incomingUuid,
            ]);
            return response()->json(['message' => 'Unauthorized webhook'], Response::HTTP_UNAUTHORIZED);
        }

        $payload = $request->all();

        $validator = Validator::make($payload, [
            'property_ids_destroyed' => ['array'],
            'property_ids_destroyed.*' => ['integer'],
            'property_ids_updated' => ['array'],
            'property_ids_updated.*' => ['integer'],
            'properties_updated' => ['array'],
            'properties_updated.*.id' => ['required', 'integer'],
            'properties_updated.*.friendly_id' => ['required', 'string'],
            'properties_updated.*.website_published' => ['required', 'boolean'],
            'properties_updated.*.promo' => ['required', 'boolean'],
            'properties_updated.*.availability' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            Log::warning('Vaunt webhook invalid payload', [
                'errors' => $validator->errors()->toArray(),
            ]);
            return response()->json(['message' => 'Invalid payload'], Response::HTTP_BAD_REQUEST);
        }

        $destroyIds = collect($payload['property_ids_destroyed'] ?? [])->unique()->values();
        $updatedIds = collect($payload['property_ids_updated'] ?? [])->unique()->values();

        if ($destroyIds->isNotEmpty()) {
            // Soft delete? For now, actually delete local records to keep site clean
            Apartment::whereIn('id', $destroyIds)->delete();
        }

        // Queue detail sync jobs for updated IDs to fetch full data
        $updatedIds->each(function (int $id) {
            SyncApartmentFromVaunt::dispatch($id)->onQueue('webhooks');
        });

        // Log counts for observability (info level)
        Log::info('Vaunt webhook processed', [
            'queued' => $updatedIds->count(),
            'deleted' => $destroyIds->count(),
        ]);

        // Vaunt only needs a 2xx success code — no body required. Return 204 No Content.
        return response(null, Response::HTTP_NO_CONTENT, [
            'X-Vaunt-Queued' => (string) $updatedIds->count(),
            'X-Vaunt-Deleted' => (string) $destroyIds->count(),
        ]);
    }
}
