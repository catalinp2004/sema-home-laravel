<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'friendly_id' => $this->friendly_id,
            'number' => $this->number,
            'type_name' => $this->type_name,
            'floor_value' => $this->floor_value,
            'room_count' => $this->room_count,
            'availability' => $this->availability,
            'usable_size_sqm' => $this->usable_size_sqm,
            'built_size_sqm' => $this->built_size_sqm,
            'total_size_sqm' => $this->total_size_sqm,
            'balcony_count' => $this->balcony_count,
            'terrace_count' => $this->terrace_count,
            'balcony_size_sqm' => $this->balcony_size_sqm,
            'garden_size_sqm' => $this->garden_size_sqm,
            'terrace_size_sqm' => $this->terrace_size_sqm,
            'bathroom_count' => $this->bathroom_count,
            'utility_values' => $this->utility_values,
            'facility_values' => $this->facility_values,
            'zone_detail_values' => $this->zone_detail_values,
            'energy_efficiency_class' => $this->energy_efficiency_class,
            'is_available' => $this->is_available ?? ($this->availability === 'available'),
            'title' => $this->title,
            'description' => $this->description,
            // Lightweight relations for listing
            'floor' => $this->whenLoaded('floor', function () {
                return [
                    'id' => $this->floor->id,
                    'level' => $this->floor->level,
                    'slug' => $this->floor->slug,
                    'name' => $this->floor->name,
                    'building' => $this->floor->relationLoaded('building') ? [
                        'id' => $this->floor->building->id,
                        'slug' => $this->floor->building->slug,
                        'name' => $this->floor->building->name,
                    ] : null,
                ];
            }),
            // Map orientation codes to Romanian labels
            'orientation' => $this->selected_orientations ? implode(', ', array_map(function ($code) {
                $map = [
                    'N' => 'nord',
                    'NE' => 'nord-est',
                    'E' => 'est',
                    'SE' => 'sud-est',
                    'S' => 'sud',
                    'SW' => 'sud-vest',
                    'W' => 'vest',
                    'NW' => 'nord-vest',
                ];

                return $map[$code] ?? $code;
            }, $this->selected_orientations)) : null,

            // Map numeric energy efficiency class to letter (separate field)
            'energy_efficiency_letter' => $this->energy_efficiency_class ? (
                [
                    1 => 'A',
                    2 => 'B',
                    3 => 'C',
                    4 => 'D',
                    5 => 'E',
                    6 => 'F',
                    7 => 'G',
                ][$this->energy_efficiency_class] ?? null
            ) : null,
            'g_content' => $this->g_content,
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($img) {
                    return [
                        'id' => $img->id,
                        'url' => $img->url,
                        'width_320_url' => $img->width_320_url,
                        'width_560_url' => $img->width_560_url,
                        'title' => $img->title,
                        'sort_order' => $img->sort_order,
                    ];
                })->values();
            }),
            'documents' => $this->documents,
        ];
    }
}
