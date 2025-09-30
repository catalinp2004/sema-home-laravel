<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id', 'level', 'slug', 'name', 'floor_d', 'floor_transform', 'floor_svg_viewbox', 'floor_plan', 'shape_paths', 'group_transform',
    ];

    protected $casts = [
        'shape_paths' => 'array',
    ];

    /**
     * Append virtual attributes to the model's array / JSON form.
     */
    protected $appends = [
        'is_sold_out',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }

    /**
     * Use slug when resolving floors from route parameters.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Determine whether this floor is sold out.
     *
     * Uses any preloaded counts (available_apartments_count or apartments_count)
     * to avoid extra queries. Falls back to a COUNT query when necessary.
     *
     * @return bool
     */
    public function getIsSoldOutAttribute(): bool
    {
        $count = null;

        if (isset($this->available_apartments_count)) {
            $count = $this->available_apartments_count;
        } elseif (isset($this->apartments_count)) {
            $count = $this->apartments_count;
        }

        if ($count === null) {
            // Fallback to a fast COUNT query scoped to available apartments.
            // Adjust the availability condition to match your domain.
            $count = $this->apartments()->where('availability', 'available')->count();
        }

        return (int) $count === 0;
    }
}
