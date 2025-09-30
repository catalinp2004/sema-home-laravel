<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ApartmentAvailabilityService
{
    /**
     * Build an availability snapshot for the interactive scene.
     * Returns per-floor and per-building counts of available apartments for a given rooms filter.
     *
     * One aggregated query groups by building_id and floor_id; building totals are derived in PHP.
     *
     * @param int|string|null $rooms 'toate' or integer (1..4). If null, no rooms filter.
     * @param int|null $buildingId Optional: limit to a single building to reduce data.
     * @return array{
     *   floors: array<int, array{building_id:int, available:int}>,
     *   buildings: array<int, array{available:int}>
     * }
     */
    public function snapshotForRooms($rooms = 'toate', ?int $buildingId = null): array
    {
        $query = DB::table('apartments')
            ->selectRaw('floors.building_id as building_id, apartments.floor_id as floor_id, COUNT(*) as available_count')
            ->join('floors', 'floors.id', '=', 'apartments.floor_id')
            ->where('apartments.availability', 'available');

        if ($rooms !== null && $rooms !== 'toate') {
            $query->where('apartments.room_count', (int) $rooms);
        }

        if ($buildingId) {
            $query->where('floors.building_id', $buildingId);
        }

        $rows = $query->groupBy('floors.building_id', 'apartments.floor_id')->get();

        $floors = [];
        $buildings = [];

        foreach ($rows as $row) {
            $bId = (int) $row->building_id;
            $fId = (int) $row->floor_id;
            $count = (int) $row->available_count;

            $floors[$fId] = [
                'building_id' => $bId,
                'available' => $count,
            ];

            if (!isset($buildings[$bId])) {
                $buildings[$bId] = ['available' => 0];
            }
            $buildings[$bId]['available'] += $count;
        }

        return [
            'floors' => $floors,
            'buildings' => $buildings,
        ];
    }
}
