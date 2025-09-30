<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'render' => $this->render,
            'floor_svg_viewbox' => $this->floor_svg_viewbox,
            'floors' => $this->whenLoaded('floors', function () {
                $resolved = FloorResource::collection($this->floors)->resolve();
                return is_array($resolved) && isset($resolved['data']) ? $resolved['data'] : $resolved;
            }),
        ];
    }
}
