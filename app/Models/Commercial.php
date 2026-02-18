<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commercial extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'headline',
        'bio',
        'hourly_rate',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'hourly_rate' => 'decimal:2',
    ];

    public function availabilities(): HasMany
    {
        return $this->hasMany(CommercialAvailability::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
