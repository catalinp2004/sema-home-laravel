<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\FloorResource;
use App\Http\Resources\ApartmentResource;

class FloorController extends Controller
{
    public function __invoke(Request $request, Building $building, Floor $floor)
    {
        // Building and Floor are resolved by slug via route-model binding.
        $floor->load(['apartments' => function ($q) {
            $q->orderBy('number');
        }]);

        // Rooms filter preference: query overrides session, else use session default
        $rooms = $request->query('camere');
        if ($rooms !== null && !in_array((string) $rooms, ['1','2','3','4','toate'], true)) {
            $rooms = 'toate';
        }
        if ($rooms === null) {
            $rooms = $request->session()->get('rooms_filter', 'toate');
        } else {
            $request->session()->put('rooms_filter', $rooms);
        }

        return Inertia::render('Floor', [
            'building' => (new BuildingResource($building))->resolve(),
            'floor' => (new FloorResource($floor))->resolve(),
            'selectedRooms' => $rooms,
        ]);
    }
}
