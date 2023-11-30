<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //categorias de productos en un discoteca
        Category::create([
            'name' => 'Bebidas Gasificadas',
        ]);

        Category::create([
            'name' => 'Bebidas Energizantes',
        ]);

        Category::create([
            'name' => 'Bebidas Alcoholicas',
        ]);

        Category::create([
            'name' => 'Bebidas sin Alcohol',
        ]);
    }
}
