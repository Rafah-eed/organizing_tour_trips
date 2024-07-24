<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function actives(): HasMany
    {
        return $this->hasMany(Active::class);
    }

    // Assuming the pivot table is named 'trip_station' and it uses 'trip_id' and 'station_id'
    public function stations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Station::class, 'station_trips')
            ->withPivot('daysNum'); // Include any additional fields from the pivot table if needed
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class , 'actives')
            ->withPivot('isOpened','date','price');
    }
}
