<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'price_buy',
        'price_sale',
        'stock',
        'stock_min',
        // 'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'product_units')
            ->withPivot('quantity');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function compras()
    {
        return $this->hasMany(Shopping::class, 'product_id');
    }
}
