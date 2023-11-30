<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_id',
        'product_id',
        'quantity',
        'price_buy',
        'total',
    ];
}
