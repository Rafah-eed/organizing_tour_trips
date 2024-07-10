<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IsOpened extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trip_id',
        'guide_id',
        'is_opened',
        'capacity',
        'date'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function guide(): BelongsTo
    {
        return $this->belongsTo(GuidesDetails::class);
    }
}
