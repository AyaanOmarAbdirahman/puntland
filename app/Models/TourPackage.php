<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'title',
        'slug',
        'duration_days',
        'price_per_person',
        'max_capacity',
        'included_services',
        'itinerary',
        'start_date',
        'status'
    ];

    protected $casts = [
        'included_services' => 'array',
        'itinerary' => 'array',
        'price_per_person' => 'float',
        'start_date' => 'date'
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
