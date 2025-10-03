<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use App\Http\Resources\ApartmentResource;

class ApartmentsController extends Controller
{
    public function __invoke(Request $request)
    {
        // Rooms filter preference (use 'camere' to align across pages); query overrides session, then persist
        $rooms = $request->query('camere');
        if ($rooms !== null && !in_array((string) $rooms, ['1','2','3','4','toate'], true)) {
            $rooms = 'toate';
        }
        if ($rooms === null) {
            $rooms = $request->session()->get('rooms_filter', 'toate');
        } else {
            $request->session()->put('rooms_filter', $rooms);
        }

        $perPage = (int) $request->query('per_page', 12);
        // Only show available apartments and eager-load floor + building for table columns
        // Deterministic ordering: building -> floor -> apartment number (numeric)
        $query = Apartment::query()
            ->available()
            ->filterByRooms($rooms)
            // join floors/buildings to order by their attributes while still selecting apartments.*
            ->join('floors', 'apartments.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->orderBy('buildings.name')
            ->orderBy('floors.level')
            // apartment.number can be numeric or string; cast to unsigned for numeric ordering
            ->orderByRaw('CAST(apartments.number AS UNSIGNED)')
            ->select('apartments.*')
            ->with(['floor.building']);

        // Accept building and floor as slugs in query params (slug-only public API).
        if ($buildingSlug = $request->query('building')) {
            $building = Building::where('slug', $buildingSlug)->first();
            if ($building) {
                $query->forBuilding($building->id);
            }
        }
        if ($floorSlug = $request->query('floor')) {
            $floor = Floor::where('slug', $floorSlug)->first();
            if ($floor) {
                $query->forFloor($floor->id);
            }
        }
        $paginator = $query->paginate($perPage)->withQueryString();

        // Starting prices per room category (1..4): min of promo_sale_price or sale_price among available apartments
        $priceMapRaw = Apartment::query()
            ->available()
            ->whereIn('room_count', [1, 2, 3, 4])
            // only consider apartments that have at least one price defined
            ->where(function ($q) {
                $q->whereNotNull('promo_sale_price')->orWhereNotNull('sale_price');
            })
            ->selectRaw('room_count, MIN(COALESCE(promo_sale_price, sale_price)) as min_price')
            ->groupBy('room_count')
            ->pluck('min_price', 'room_count')
            ->toArray();

        // Normalize keys (room_count may be stored as decimal/string like '1.0')
        $priceMap = [];
        foreach ($priceMapRaw as $k => $v) {
            $intKey = (string) ((int) $k);
            $priceMap[$intKey] = $v;
        }

        // Normalize keys to strings for frontend and values to float
        $startingPrices = [];
        foreach ([1,2,3,4] as $rc) {
            $key = (string) $rc;
            $val = $priceMap[$key] ?? null;
            $startingPrices[$key] = $val !== null ? (float) $val : null;
        }

        $items = ApartmentResource::collection($paginator->getCollection())->resolve();

        return Inertia::render('Apartments', [
            'apartments' => $items,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'filters' => ['camere' => $rooms],
            'starting_prices' => $startingPrices,
        ]);
    }
}
