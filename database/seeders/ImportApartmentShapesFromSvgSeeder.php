<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportApartmentShapesFromSvgSeeder extends Seeder
{
    /**
     * For each floor (building_id, level) this seeder looks for an SVG file at:
     *   storage/app/private/apartment_shapes_{buildingId}_{level}.svg
     * The SVG is expected to contain only <path> or <rect> elements directly under <svg>.
     * Each element must have a data-name attribute that matches the apartments.number value
     * for the target floor. For each matching apartment, we store the sanitized element
     * (id, data-name, opacity removed; fill set to currentColor) in apartments.g_content.
     * Additionally, the floor's floor_svg_viewbox is updated from the root svg viewBox.
     */
    public function run()
    {
        $floors = DB::table('floors')
            ->select('id', 'building_id', 'level')
            ->orderBy('building_id')
            ->orderBy('level')
            ->get();

        if ($floors->isEmpty()) {
            $this->command->info('No floors found in database; nothing to import.');
            return;
        }

        foreach ($floors as $floor) {
            $file = storage_path("app/private/apartment_shapes_{$floor->building_id}_{$floor->level}.svg");
            if (! file_exists($file)) {
                $this->command->info("No SVG for building {$floor->building_id} level {$floor->level} at: {$file} — skipping");
                continue;
            }

            $this->command->info("Importing apartment shapes for floor {$floor->id} (building {$floor->building_id}, level {$floor->level}) from: {$file}");

            $svg = file_get_contents($file);
            if ($svg === false) {
                $this->command->error("Failed to read SVG file at: {$file}");
                continue;
            }

            // Parse SVG
            $doc = new \DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $doc->loadXML($svg);
            libxml_clear_errors();

            $svgEl = $doc->getElementsByTagName('svg')->item(0);
            if (! $svgEl) {
                $this->command->error("No <svg> element found in file: {$file}");
                continue;
            }

            // Update the floor's viewBox if present
            $viewBox = $svgEl->getAttribute('viewBox') ?: null;
            if ($viewBox) {
                DB::table('floors')->where('id', $floor->id)->update(['floor_svg_viewbox' => $viewBox]);
                $this->command->info("Updated floor {$floor->id} floor_svg_viewbox to: {$viewBox}");
            }

            $updated = 0;
            $notMatched = 0;

            // Prefetch apartment numbers for this floor into a map to avoid per-element exists checks
            $apartmentMap = DB::table('apartments')
                ->where('floor_id', $floor->id)
                ->pluck('id', 'number')
                ->toArray();

            // Walk only direct children
            foreach ($svgEl->childNodes as $child) {
                if (! ($child instanceof \DOMElement)) {
                    continue;
                }

                $tag = $child->tagName;
                if ($tag !== 'path' && $tag !== 'rect') {
                    // Skip unsupported elements
                    continue;
                }

                $aptNumber = $child->getAttribute('data-name');
                if ($aptNumber === '') {
                    $this->command->warn("<{$tag}> without data-name in {$file} — skipping element");
                    continue;
                }

                // Clone and sanitize element
                $clone = $child->cloneNode(true);
                $clone->removeAttribute('id');
                $clone->removeAttribute('data-name');
                $clone->removeAttribute('opacity');

                // Ensure fill uses currentColor
                if ($clone->hasAttribute('fill')) {
                    $clone->setAttribute('fill', 'currentColor');
                } else {
                    // add a fill attribute for consistent theming
                    $clone->setAttribute('fill', 'currentColor');
                }

                // Remove any xmlns attributes -- these are only needed on the root <svg>
                // and aren't required (and may be undesirable) on child <path>/<rect> fragments.
                if ($clone->hasAttribute('xmlns')) {
                    $clone->removeAttribute('xmlns');
                }
                // also remove common namespaced xmlns:xlink if present
                if ($clone->hasAttribute('xmlns:xlink')) {
                    $clone->removeAttribute('xmlns:xlink');
                }

                // Serialize the sanitized element to XML string
                $tmp = new \DOMDocument('1.0', 'UTF-8');
                $tmp->formatOutput = false;
                $imported = $tmp->importNode($clone, true);
                $tmp->appendChild($imported);
                $elementXml = trim($tmp->saveXML($imported));

                // As a fallback, strip any xmlns declarations that may have been serialized
                // by DOM when importing namespaced nodes.
                $elementXml = preg_replace('/\s+xmlns(:\w+)?="[^"]+"/i', '', $elementXml);

                // If the apartment number exists on this floor (per map) attempt update and count it
                if (array_key_exists($aptNumber, $apartmentMap)) {
                    DB::table('apartments')
                        ->where('floor_id', $floor->id)
                        ->where('number', $aptNumber)
                        ->update(['g_content' => $elementXml]);

                    // count as updated (we prefer simplicity; it's OK if update resulted in 0 affected rows)
                    $updated++;
                } else {
                    $this->command->warn("No apartment found on floor {$floor->id} with number '{$aptNumber}'");
                    $notMatched++;
                }
            }

            $summary = "Floor {$floor->id}: updated {$updated} apartments";
            if ($notMatched > 0) {
                $summary .= " ({$notMatched} not matched)";
            }
            $this->command->info($summary);
        }

        $this->command->info('Apartment shapes import completed.');
    }
}
