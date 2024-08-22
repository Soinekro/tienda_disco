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
            'name' => 'Memoria RAM 8GB',
            'price_buy' => 50,
            'price_sale' => 100,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Memoria RAM 16GB',
            'price_buy' => 100,
            'price_sale' => 150,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Memoria RAM 32GB',
            'price_buy' => 150,
            'price_sale' => 200,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Procesador Intel i5',
            'price_buy' => 200,
            'price_sale' => 300,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Procesador Intel i7',
            'price_buy' => 300,
            'price_sale' => 400,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Procesador Intel i9',
            'price_buy' => 400,
            'price_sale' => 500,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Disco Duro 500GB',
            'price_buy' => 50,
            'price_sale' => 100,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Disco Duro 1TB',
            'price_buy' => 100,
            'price_sale' => 150,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Disco Duro 2TB',
            'price_buy' => 150,
            'price_sale' => 200,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Disco Duro 4TB',
            'price_buy' => 200,
            'price_sale' => 250,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Tarjeta de Video 2GB',
            'price_buy' => 250,
            'price_sale' => 300,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Tarjeta de Video 4GB',
            'price_buy' => 300,
            'price_sale' => 400,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Tarjeta de Video 8GB',
            'price_buy' => 400,
            'price_sale' => 500,
            'category_id' => 1,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Computadora HP',
            'price_buy' => 300,
            'price_sale' => 500,
            'category_id' => 2,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Computadora Dell',
            'price_buy' => 400,
            'price_sale' => 600,
            'category_id' => 2,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Computadora Lenovo',
            'price_buy' => 500,
            'price_sale' => 700,
            'category_id' => 2,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Laptop HP',
            'price_buy' => 500,
            'price_sale' => 800,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Laptop Dell',
            'price_buy' => 600,
            'price_sale' => 900,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Laptop Lenovo',
            'price_buy' => 700,
            'price_sale' => 1000,
            'category_id' => 3,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Monitor HP',
            'price_buy' => 200,
            'price_sale' => 300,
            'category_id' => 4,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Monitor Dell',
            'price_buy' => 250,
            'price_sale' => 350,
            'category_id' => 4,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Monitor Lenovo',
            'price_buy' => 300,
            'price_sale' => 400,
            'category_id' => 4,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Teclado HP',
            'price_buy' => 10,
            'price_sale' => 20,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Teclado Dell',
            'price_buy' => 15,
            'price_sale' => 25,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Teclado Lenovo',
            'price_buy' => 20,
            'price_sale' => 30,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Mouse HP',
            'price_buy' => 5,
            'price_sale' => 10,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Mouse Dell',
            'price_buy' => 7,
            'price_sale' => 12,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Mouse Lenovo',
            'price_buy' => 10,
            'price_sale' => 15,
            'category_id' => 5,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Windows 10',
            'price_buy' => 100,
            'price_sale' => 150,
            'category_id' => 6,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Office 365',
            'price_buy' => 150,
            'price_sale' => 200,
            'category_id' => 6,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);

        Product::create([
            'name' => 'Antivirus',
            'price_buy' => 50,
            'price_sale' => 100,
            'category_id' => 6,
            'stock'=> rand(20,100),
            'stock_min' => 10,
        ]);
    }
}
