<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'tour_package_id',
        'full_name',
        'email',
        'phone',
        'current_location',
        'emergency_contact',
        'travel_date',
        'number_of_guests',
        'total_price',
        'special_requests',
        'rejection_reason',
        'status',
        'payment_status'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_price' => 'float'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }
}
