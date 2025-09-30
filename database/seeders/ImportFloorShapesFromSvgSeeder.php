<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportFloorShapesFromSvgSeeder extends Seeder
{
    /**
     * Expect an SVG file under storage/app/private by default.
     * This seeder can optionally accept a single parameter when called programmatically:
     *  - an integer building id (e.g. 5) -> the seeder will try several candidate filenames/locations
     *  - a string that ends with .svg -> treated as a relative path under storage/app/private or an absolute path
     *
     * If a given floor has multiple shapes (multiple <path> children), the seeder
     * writes a JSON array into `shape_paths` column: [{d, transform}, ...]
     * If a given floor has a single path, it writes `floor_d` and `floor_transform`.
     *
     * Usage examples:
     *  (1) Called by framework: $this->call(ImportFloorShapesFromSvgSeeder::class) -> will use storage/app/private/floor_shapes.svg
     *  (2) Programmatic call: (new ImportFloorShapesFromSvgSeeder)->run(5) -> will try building-specific files for id=5
     *  (3) Programmatic call with path: (new ImportFloorShapesFromSvgSeeder)->run('my_building/floor_shapes.svg')
     */
    public function run()
    {
        // Iterate over all buildings by id and attempt to import storage/app/private/floor_shapes_{id}.svg
        $buildingIds = DB::table('buildings')->pluck('id')->all();
        if (empty($buildingIds)) {
            $this->command->info('No buildings found in database; nothing to import.');
            return;
        }

        foreach ($buildingIds as $id) {
            $path = storage_path("app/private/floor_shapes_{$id}.svg");
            if (! file_exists($path)) {
                $this->command->info("No SVG for building id {$id} at: {$path} — skipping");
                continue;
            }

            $this->command->info("Importing floor shapes for building id {$id} from: {$path}");

            $svg = file_get_contents($path);
            if ($svg === false) {
                $this->command->error("Failed to read SVG file for building id {$id} at: {$path}");
                continue;
            }

            // Load XML
            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadXML($svg);
            libxml_clear_errors();

            $svgEl = $doc->getElementsByTagName('svg')->item(0);
            if (! $svgEl) {
                $this->command->error("No <svg> element found in file for building id {$id} at: {$path}");
                continue;
            }

            // If the root svg element has a viewBox attribute, persist it to the building
            $viewBox = $svgEl->getAttribute('viewBox') ?: null;
            if ($viewBox) {
                DB::table('buildings')->where('id', $id)->update(['floor_svg_viewbox' => $viewBox]);
                $this->command->info("Updated building {$id} floor_svg_viewbox to: {$viewBox}");
            }

        // Iterate immediate child nodes of svg
        foreach ($svgEl->childNodes as $child) {
            if (! ($child instanceof \DOMElement)) {
                continue;
            }

            $id = $child->getAttribute('id');
            if (! $id) {
                continue; // skip elements without id
            }

            // The ID might be numeric; if not, attempt to extract numeric prefix
            $floorId = is_numeric($id) ? (int) $id : (int) preg_replace('/[^0-9].*/', '', $id);
            if ($floorId <= 0) {
                $this->command->warn("Skipping element with non-numeric id: {$id}");
                continue;
            }

            // Collect paths inside this group or element
            $groupTransform = null;
            $paths = [];
            if ($child->tagName === 'path') {
                $d = $child->getAttribute('d');
                $transform = $child->getAttribute('transform');
                $paths[] = ['d' => $d, 'transform' => $transform ?: null];
            } else {
                // find descendant paths
                $groupTransform = $child->getAttribute('transform') ?: null;
                $innerPaths = $child->getElementsByTagName('path');
                foreach ($innerPaths as $p) {
                    /** @var \DOMElement $p */
                    $d = $p->getAttribute('d');
                    $transform = $p->getAttribute('transform');
                    $paths[] = ['d' => $d, 'transform' => $transform ?: null];
                }
            }

            if (empty($paths)) {
                $this->command->warn("No <path> found for element id={$id}");
                continue;
            }

            if (count($paths) === 1 && $child->tagName === 'path') {
                // single path -> write floor_d, floor_transform and clear shape_paths
                $d = $paths[0]['d'];
                $transform = $paths[0]['transform'];
                DB::table('floors')->where('id', $floorId)->update([
                    'floor_d' => $d,
                    'floor_transform' => $transform,
                    'shape_paths' => null,
                    'group_transform' => null,
                ]);
                $this->command->info("Updated floor {$floorId} with single path");
            } else {
                // multi-shape or grouped -> store JSON in shape_paths and group_transform; clear floor_d/transform
                DB::table('floors')->where('id', $floorId)->update([
                    'shape_paths' => json_encode($paths),
                    'group_transform' => $groupTransform,
                    'floor_d' => null,
                    'floor_transform' => null,
                ]);
                $this->command->info("Updated floor {$floorId} with " . count($paths) . " shape(s)" . ($groupTransform ? ' and group transform' : ''));
            }
        }
        }

        $this->command->info('Import completed');
    }
}
