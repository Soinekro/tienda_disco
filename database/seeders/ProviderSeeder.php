<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::create([
            'ruc' => '10235458962',
            'name' => 'Distribuidora de Bebidas',
            'phone' => '123456789',
            'address' => 'Av. Los Incas 123',
        ]);
    }
}
