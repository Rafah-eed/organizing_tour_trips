<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'capacity'
    ];



    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isOpened(): HasMany
    {
        return $this->hasMany(Active::class);
    }

    public function stationTrips(): HasMany
    {
        return $this->hasMany(StationTrip::class);
    }

    // Assuming the pivot table is named 'trip_station' and it uses 'trip_id' and 'station_id'
    public function stations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Station::class, 'station_trips', 'trip_id', 'station_id')
            ->withPivot('daysNum'); // Include any additional fields from the pivot table if needed
    }
}
