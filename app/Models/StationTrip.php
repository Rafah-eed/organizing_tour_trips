<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StationTrip extends Model
{
    use HasFactory;
    protected $fillable = [
        'station_id',
        'trip_id',
        'daysNum'
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
