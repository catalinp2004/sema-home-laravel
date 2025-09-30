<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Building;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\FloorResource;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Rooms filter can come from query or fall back to session; persist preference in session
        $rooms = $request->query('camere');
        if ($rooms !== null && !in_array((string) $rooms, ['1','2','3','4','toate'], true)) {
            $rooms = 'toate';
        }
        if ($rooms === null) {
            $rooms = $request->session()->get('rooms_filter', 'toate');
        } else {
            $request->session()->put('rooms_filter', $rooms);
        }

        // Load Building #1 with floors and filtered available apartments count per-floor
        $building = Building::with(['floors' => function ($q) use ($rooms) {
            $q->withCount(['apartments as available_apartments_count' => function ($sub) use ($rooms) {
                $sub->where('availability', 'available');
                if ($rooms !== 'toate') {
                    $sub->where('room_count', (int) $rooms);
                }
            }])->orderBy('level');
        }])->find(1);

        return Inertia::render('Home', [
            // resolve the resource to array so Inertia receives a plain object
            // (JsonResource when returned directly wraps single resources in a `data` key)
            'building' => $building ? (new BuildingResource($building))->resolve() : null,
            'selectedRooms' => $rooms,
        ]);
    }
}
