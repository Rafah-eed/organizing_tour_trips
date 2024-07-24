<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Active extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',// which is the guide ID
        'isOpened',
        'date',
        'price'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
