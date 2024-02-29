<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asking extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'content',
        'email',
        'phone',
        'status',
    ];
}
