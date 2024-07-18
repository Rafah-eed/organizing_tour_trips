<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'photo',
        'address',
        'contactInfo',
        'type'
    ];


    public function restaurants(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(stationTrip::class)->withPivot("daysNum");
    }

    public function trips(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Trip::class, 'station_trips', 'station_id', 'trip_id')
            ->withPivot('daysNum'); // Include any additional fields from the pivot table if needed
    }
}
