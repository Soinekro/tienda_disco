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
        ]);
        TypePay::create([
            'name' => 'Tarjeta',
        ]);
        TypePay::create([
            'name' => 'Transferencia',
        ]);
        TypePay::create([
            'name' => 'Yape',
        ]);
        TypePay::create([
            'name' => 'Plin',
        ]);
    }
}
