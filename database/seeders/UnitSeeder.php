<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'id' => 'NIU',
                'name' => 'UNIDAD',
                'status' => true,
                'quantity'=> 1
            ],

            [
                'id' => 'ZZ',
                'name' => 'SERVICIO',
                'status' => true,
                'quantity'=> 1
            ],
            [
                'id' => 'BX',
                'name' => 'CAJA',
                'status' => true,
                'quantity'=>null
            ],
            [
                'id' => 'BO',
                'name' => 'BOTELLA',
                'status' => true,
                'quantity'=> 1
            ],
            [
                'id' => 'CEN',
                'name' => 'CIENTO DE UNIDADES',
                'status' => true,
                'quantity'=> 100
            ],
        ]);

        $products = DB::table('products')->get();

        foreach ($products as $product) {
            DB::table('product_units')->insert([
                [
                    'product_id' => $product->id,
                    'unit_id' => 'NIU',
                    'quantity' => 1,
                ],
            ]);
        }
    }
}
