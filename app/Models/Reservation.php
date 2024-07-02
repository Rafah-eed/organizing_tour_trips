<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'isOpened_id', 
        'user_id',
        'reserve_statue'
    ];

    public function isOpened(): BelongsTo
    {
        return $this->belongsTo(IsOpened::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
