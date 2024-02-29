<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamme extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
    ];

    //nom de le fonction au pluriel car une gamme peut regrouper plusieurs products
    // cardinalité 1,n
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
