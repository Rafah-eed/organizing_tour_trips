<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bookHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 
        'user_id',
        'date',
        'daysNum',
        'price'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
