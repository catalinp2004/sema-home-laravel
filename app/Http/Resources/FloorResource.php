<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FloorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'slug' => $this->slug,
            'name' => $this->name,
            'floor_plan' => $this->floor_plan,
            'floor_d' => $this->floor_d,
            'floor_transform' => $this->floor_transform,
            'floor_svg_viewbox' => $this->floor_svg_viewbox,
            'shape_paths' => $this->shape_paths,
            'group_transform' => $this->group_transform,
            'available_apartments_count' => $this->available_apartments_count,
            'apartments_count' => $this->apartments_count,
            'is_sold_out' => $this->is_sold_out,
            'apartments' => $this->whenLoaded('apartments', function () {
                return ApartmentResource::collection($this->apartments)->resolve();
            }),
        ];
    }
}
