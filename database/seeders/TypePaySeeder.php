<?php

namespace Database\Seeders;

use App\Models\TypePay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypePaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypePay::create([
            'name' => 'Efectivo',
            'type' => 'E',
        ]);
        TypePay::create([
            'name' => 'Tarjeta',
            'type' => 'E',
        ]);
        TypePay::create([
            'name' => 'Transferencia',
            'type' => 'E',
        ]);
        TypePay::create([
            'name' => 'Yape',
            'type' => 'E',
        ]);
        TypePay::create([
            'name' => 'Plin',
            'type' => 'E',
        ]);
    }
}
