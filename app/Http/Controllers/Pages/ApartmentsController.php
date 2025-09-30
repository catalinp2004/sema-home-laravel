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
        $query = Apartment::query()
            ->available()
            ->filterByRooms($rooms)
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
        ]);
    }
}
