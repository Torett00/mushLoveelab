<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'price',
        'stock',
        'product_id',
        'description'
    ];
    public function variationn(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
