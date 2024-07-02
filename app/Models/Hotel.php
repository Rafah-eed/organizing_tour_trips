<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'station_id', 
        'name',
        'phone',
        'address'
    ];

    public function bookHotels(): HasMany
    {
        return $this->hasMany(bookHotel::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(station::class);
    }
}
