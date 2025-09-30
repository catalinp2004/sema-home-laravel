<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use App\Http\Resources\ApartmentResource;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\FloorResource;


class ApartmentController extends Controller
{
    public function __invoke(Request $request, Building $building, Floor $floor, Apartment $apartment)
    {
        // Models are resolved via route-model binding (friendly_id for Apartment).
        $apartment->load('images');

        return Inertia::render('Apartment', [
            'building' => (new BuildingResource($building))->resolve(),
            'floor' => (new FloorResource($floor))->resolve(),
            'apartment' => (new ApartmentResource($apartment))->resolve(),
        ]);
    }
}
