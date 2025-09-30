<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BuildingAndFloorsSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = range(1, 1);
        foreach ($buildings as $building) {
            $name = 'Clădirea ' . $building;
            $slug = Str::slug($name);
            $building = Building::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'render' => 'etaje-' . $slug . '-sema-home',
                    'building_d' => 'placeholder-path',
                    'building_transform' => 'translate(0,0) scale(1)',
                    'floor_svg_viewbox' => '0 0 100 100',
                ]
            );
        }

        // Create floors with names matching the provider format: "Parter", "Etaj 1" .. "Etaj 11"
        $levels = array_merge(['Parter'], range(1, 11));
        $floor_renders_building_1 = ['parter', 'etaj-1', 'etaj-2', 'etaje-3-4', 'etaje-3-4', 'etaje-5-6-7', 'etaje-5-6-7', 'etaje-5-6-7', 'etaj-8', 'etaj-9', 'etaj-10', 'etaj-11'];
        
        foreach ($levels as $i => $level) {
            $name = $level === 'Parter' ? 'Parter' : ('Etaj ' . $level);
            $slug = Str::slug($name);

            Floor::firstOrCreate(
                ['building_id' => $building->id, 'name' => $name],
                [
                    'level' => $level === 'Parter' ? 0 : (int) $level,
                    'slug' => $slug,
                    'floor_d' => 'placeholder-path',
                    'floor_transform' => 'translate(0,0) scale(1)',
                    'floor_svg_viewbox' => '0 0 100 100',
                    'floor_plan' => 'plan-' . $floor_renders_building_1[$i] . '-' . $building->slug . '-sema-home',
                ]
            );
        }
    }
}
