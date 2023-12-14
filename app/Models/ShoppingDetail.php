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
        'product_unit_id',
        'price_buy',
        'total',
    ];

    public function shopping()
    {
        return $this->belongsTo(Shopping::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }
    
    public function scopeShopping($query, $id)
    {
        return $query->where('shopping_id', $id);
    }
}
