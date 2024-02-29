<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'gamme_id',
        'name',
        'desc',
        'full_desc',
        'image',
        'price',
        'dispo',
    ];

    public function gamme()
    {
        return $this->belongsTo(Gamme::class);
    }

    public function satisfactions()
    {
        return $this->belongsToMany(User::class, 'satisfactions')->withPivot('note');
    }
}
