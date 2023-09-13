<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'price',
        'stock',
        'categorie_id',
        'description'
    ];
    public function categorie(): HasOne
    {
        return $this->hasOne(Categorie::class);
    }
}
