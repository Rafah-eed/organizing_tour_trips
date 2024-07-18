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

    public function isOpened(): HasMany
    {
        return $this->hasMany(Active::class);
    }

    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(StationTrip::class)->withPivot("daysNum");
    }
}
