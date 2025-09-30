<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Building;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\FloorResource;

class BuildingController extends Controller
{
    public function __invoke(Request $request, Building $building)
    {

        // TEMPORARY REDIRECT TO HOME
        return redirect()->route('home');

        // Building is resolved by slug via route-model binding. Eager-load floors with apartments_count.
        $building->load(['floors' => function ($q) {
            $q->withCount('apartments')->orderBy('level');
        }]);

        $floors = $building->floors->map(function ($f) {
            return $f->only(['id', 'level', 'slug', 'name']);
        });

        $floorCounts = [];
        foreach ($building->floors as $f) {
            $floorCounts[$f->id] = $f->apartments_count ?? 0;
        }

        return Inertia::render('Building', [
            'building' => (new BuildingResource($building))->resolve(),
            'floors' => $floors,
            'apartment_counts' => $floorCounts,
        ]);
    }
}
