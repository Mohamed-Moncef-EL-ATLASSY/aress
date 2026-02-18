<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommercialAvailability extends Model
{
    protected $fillable = [
        'commercial_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Commercial::class);
    }
}
