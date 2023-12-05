<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Coca Cola',
            'price_buy' => 2.8,
            'price_sale' => 5,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Pepsi',
            'price_buy' => 2.7,
            'price_sale' => 5,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Red Bull',
            'price_buy' => 2.6,
            'price_sale' => 10,
            'category_id' => 2,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Vodka Smirnof',
            'price_buy' => 32,
            'price_sale' => 80,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Ron Cartavio',
            'price_buy' => 35,
            'price_sale' => 90,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Pisco',
            'price_buy' => 28,
            'price_sale' => 50,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
        Product::create([
            'name' => 'Agua',
            'price_buy' => 2.1,
            'price_sale' => 5,
            'category_id' => 4,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

    }
}
