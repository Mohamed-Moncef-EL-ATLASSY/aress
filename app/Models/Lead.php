<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    public const STATUS_NEW = 'New';
    public const STATUS_CONTACTED = 'Contacted';
    public const STATUS_INTERESTED = 'Interested';
    public const STATUS_NEGOTIATION = 'Negotiation';
    public const STATUS_WON = 'Won';
    public const STATUS_LOST = 'Lost';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_CONTACTED,
        self::STATUS_INTERESTED,
        self::STATUS_NEGOTIATION,
        self::STATUS_WON,
        self::STATUS_LOST,
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_source',
        'company_source_id',
        'status',
        'notes',
        'events',
    ];

    protected $casts = [
        'events' => 'array',
    ];

    public function companySource(): BelongsTo
    {
        return $this->belongsTo(CompanySource::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class);
    }
}
