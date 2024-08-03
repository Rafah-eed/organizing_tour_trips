<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bookStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'user_id',
        'date',
        'daysNum'
    ];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
