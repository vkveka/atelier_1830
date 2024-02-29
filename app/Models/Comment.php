<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'title',
        'note',
    ];

    // je charge automatiquement l'utilisateur à chaque fois que je récupère un message
    protected $with = ['user'];

    // idem
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
