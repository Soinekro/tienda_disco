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
        'image',
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

    public function salelists()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function compras()
    {
        return $this->hasMany(ShoppingDetail::class, 'product_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
