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
        return $this->hasMany(IsOpened::class);
    }

    public function stationTrips(): HasMany
    {
        return $this->hasMany(stationTrip::class);
    }
}
