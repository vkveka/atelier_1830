<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero',
        'price',
        'pickup_date',
    ];

    // je charge automatiquement l'utilisateur à chaque fois que je récupère un message
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'commande_articles')->withPivot('quantity');
    }
}
