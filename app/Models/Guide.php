<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fatherName',
        'lastName',
        'phone',
        'address',
        'email',
        'password',
        'bankName',
        'accountNumber',
        'goneTrips',
        'totalTripsNumber',
        'salary'
    ];

    public function isOpened(): HasMany
    {
        return $this->hasMany(IsOpened::class);
    }
}
