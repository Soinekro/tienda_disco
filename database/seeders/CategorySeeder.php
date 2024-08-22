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
        //categorias de productos en una tienda de soporte tecnico de computadoras
        Category::create([
            'name' => 'Accesorios',
        ]);

        Category::create([
            'name' => 'Computadoras',
        ]);

        Category::create([
            'name' => 'Laptops',
        ]);

        Category::create([
            'name' => 'Monitores',
        ]);

        Category::create([
            'name' => 'Perifericos',
        ]);

        Category::create([
            'name' => 'Software',
        ]);
    }
}
