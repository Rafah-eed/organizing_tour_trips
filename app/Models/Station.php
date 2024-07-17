<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function stationTrips(): HasMany
    {
        return $this->hasMany(stationTrip::class);
    }
}
