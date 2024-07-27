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

    // In Station.php model
    public function users()
    {
        return $this->belongsToMany(User::class, 'bookstation');
    }



    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class, 'station_trips')
            ->withPivot('daysNum'); // Include any additional fields from the pivot table if needed
    }
}
