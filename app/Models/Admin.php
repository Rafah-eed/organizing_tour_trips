<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
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
        'tripsNumber'
    ];

}
