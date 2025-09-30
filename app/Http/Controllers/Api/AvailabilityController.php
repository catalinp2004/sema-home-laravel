<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApartmentAvailabilityService;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request, ApartmentAvailabilityService $service)
    {
        $rooms = $request->query('rooms', 'toate'); // 'toate' or 1..4
        $buildingId = $request->query('building_id'); // optional

        $snapshot = $service->snapshotForRooms($rooms, $buildingId ? (int) $buildingId : null);

        return response()->json($snapshot);
    }
}
