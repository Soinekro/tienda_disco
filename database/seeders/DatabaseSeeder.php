<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
        \App\Models\User::factory(10)->create();
        $isa=\App\Models\User::create([
            'name' => 'Isai Romero',
            'email' => 'isai@mail.com',
            'username' => 'isai',
            'phone' => '123456789',
            'password' => Hash::make('12345678'),
        ]);
        $isa->assignRole(['super admin']);
        $juan = \App\Models\User::create([
            'name' => 'Juan Cegarra',
            'email' => 'juan@mail.com',
            'username' => 'juan',
            'phone' => '987654321',
            'password' => Hash::make('12345678'),
        ]);
        $juan->assignRole(['soporte']);

        $this->call([
            InvoiceSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            ProductSeeder::class,
            ProviderSeeder::class,
            TypePaySeeder::class,
            ClientSeeder::class,
        ]);
    }
}
