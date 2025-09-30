<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ApartmentImage;

class Apartment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id', 'floor_id', 'type_name', 'selected_orientations', 'friendly_id', 'title', 'description',
        'website_latitude', 'website_longitude', 'website_address', 'room_count', 'usable_size_sqm', 'built_size_sqm',
        'year_built', 'built_state', 'bathroom_count', 'floor_count', 'sale_price', 'promo_sale_price', 'price_per_sqm',
        'floor_value', 'home_type', 'layout_value', 'confort_value', 'balcony_size_sqm', 'total_size_sqm', 'garden_size_sqm',
        'availability', 'kitchen_type', 'number', 'utility_values', 'facility_values', 'finish_values', 'service_values',
        'zone_detail_values', 'balcony_count', 'kitchen_count', 'garage_count', 'parking_spots_count', 'terrace_count',
        'terrace_size_sqm', 'virtual_tour_url', 'videos', 'energy_efficiency_class', 'api_created_at', 'api_updated_at',
    'website_published', 'promo', 'zone', 'agent_id', 'documents', 'project_id', 'client_id',
    ];

    protected $casts = [
        'selected_orientations' => 'array',
        'utility_values' => 'array',
        'facility_values' => 'array',
        'finish_values' => 'array',
        'service_values' => 'array',
        'zone_detail_values' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'website_published' => 'boolean',
        'promo' => 'boolean',
        'api_created_at' => 'datetime',
        'api_updated_at' => 'datetime',
        'website_latitude' => 'decimal:8',
        'website_longitude' => 'decimal:8',
        'room_count' => 'decimal:1',
        'usable_size_sqm' => 'decimal:2',
        'built_size_sqm' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'promo_sale_price' => 'decimal:2',
        'price_per_sqm' => 'decimal:2',
        'balcony_size_sqm' => 'decimal:2',
        'total_size_sqm' => 'decimal:2',
        'garden_size_sqm' => 'decimal:2',
        'terrace_size_sqm' => 'decimal:2',
    ];

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ApartmentImage::class)->orderBy('sort_order');
    }

    // Scopes
    /** Filter apartments by number of rooms. Accepts 'toate' or an integer (1..4). */
    public function scopeFilterByRooms(Builder $query, $rooms): Builder
    {
        if ($rooms === null || $rooms === 'toate') {
            return $query; // no filter
        }

        return $query->where('room_count', '=', (int) $rooms);
    }

    /** Only apartments that are available (website_published ignored for now) */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('availability', 'available');
    }

    /** Apartments not available for selection (sold, reserved, unavailable, let) */
    public function scopeUnavailable(Builder $query): Builder
    {
        return $query->whereIn('availability', ['sold', 'reserved', 'unavailable', 'let', 'hold']);
    }

    /** Constrain apartments to a given building via floor relationship */
    public function scopeForBuilding(Builder $query, int $buildingId): Builder
    {
        return $query->whereHas('floor', function (Builder $q) use ($buildingId) {
            $q->where('building_id', $buildingId);
        });
    }

    /** Constrain apartments to a specific floor */
    public function scopeForFloor(Builder $query, int $floorId): Builder
    {
        return $query->where('floor_id', $floorId);
    }

    // Accessors
    public function getIsAvailableAttribute(): bool
    {
        return $this->availability === 'available';
    }

    /**
     * Use friendly_id (slug) for route-model binding in public URLs.
     */
    public function getRouteKeyName()
    {
        return 'friendly_id';
    }
}
