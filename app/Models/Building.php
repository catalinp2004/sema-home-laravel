<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'render', 'building_d', 'building_transform', 'floor_svg_viewbox',
    ];

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }

    /**
     * Access apartments of this building through floors for aggregation/filtering.
     */
    public function apartments(): HasManyThrough
    {
        return $this->hasManyThrough(Apartment::class, Floor::class);
    }

    /**
     * Use slug for route-model binding (public-facing pages are slug-only)
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
