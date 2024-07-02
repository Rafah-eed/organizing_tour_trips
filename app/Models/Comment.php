<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 
        'user_id',
        'comment'
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
