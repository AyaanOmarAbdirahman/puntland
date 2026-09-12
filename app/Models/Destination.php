<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'region',
        'city',
        'description',
        'latitude',
        'longitude',
        'featured_image',
        'gallery',
        'entry_fee',
        'rating',
        'is_featured',
        'best_season'
    ];

    protected $casts = [
        'gallery' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'entry_fee' => 'float',
        'rating' => 'float',
        'is_featured' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tourPackages(): HasMany
    {
        return $this->hasMany(TourPackage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function savedBy(): HasMany
    {
        return $this->hasMany(SavedPlace::class);
    }

    public function getStartingPriceAttribute(): float
    {
        $pkgMin = $this->tourPackages()->min('price_per_person');
        if ($pkgMin && $pkgMin > 0) {
            return (float) $pkgMin;
        }

        // Fallback to city packages
        $cityMin = TourPackage::whereHas('destination', function($q) {
            $q->where('city', $this->city);
        })->min('price_per_person');

        if ($cityMin && $cityMin > 0) {
            return (float) $cityMin;
        }

        return (float) ($this->entry_fee > 0 ? $this->entry_fee : 55.00);
    }
}
