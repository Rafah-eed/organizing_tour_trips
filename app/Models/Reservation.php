<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'active_id',
        'reserve_statue',
        'has_paid'
    ];

    public function active(): BelongsTo
    {
        return $this->belongsTo(Active::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
