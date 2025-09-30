<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApartmentImage extends Model
{
    use HasFactory;

    protected $table = 'apartment_images';

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id', 'apartment_id', 'url', 'width_320_url', 'width_560_url', 'title', 'description', 'image_processing', 'api_created_at', 'sort_order',
    ];

    protected $casts = [
        'image_processing' => 'boolean',
        'api_created_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
