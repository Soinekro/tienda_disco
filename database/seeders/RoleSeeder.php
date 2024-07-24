<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_s = Role::create(['name' => 'super admin']);
        $admin = Role::create(['name' => 'admin']);
        $soporte = Role::create(['name' => 'soporte']);

        //
        $categories_index = Permission::create([
            'name' => 'admin.categories.index',
            'description' => 'Ver listado de categorias'
        ]);

        $categories_create = Permission::create([
            'name' => 'admin.categories.create',
            'description' => 'Crear categorias'
        ]);

        $categories_edit = Permission::create([
            'name' => 'admin.categories.edit',
            'description' => 'Editar categorias'
        ]);

        $categories_destroy = Permission::create([
            'name' => 'admin.categories.destroy',
            'description' => 'Eliminar categorias'
        ]);

        $products_index = Permission::create([
            'name' => 'admin.products.index',
            'description' => 'Ver listado de productos'
        ]);

        $products_create = Permission::create([
            'name' => 'admin.products.create',
            'description' => 'Crear productos'
        ]);

        $products_edit = Permission::create([
            'name' => 'admin.products.edit',
            'description' => 'Editar productos'
        ]);

        $products_destroy = Permission::create([
            'name' => 'admin.products.destroy',
            'description' => 'Eliminar productos'
        ]);

        $providers_index = Permission::create([
            'name' => 'admin.providers.index',
            'description' => 'Ver listado de proveedores'
        ]);

        $providers_create = Permission::create([
            'name' => 'admin.providers.create',
            'description' => 'Crear proveedores'
        ]);

        $providers_edit = Permission::create([
            'name' => 'admin.providers.edit',
            'description' => 'Editar proveedores'
        ]);

        $providers_destroy = Permission::create([
            'name' => 'admin.providers.destroy',
            'description' => 'Eliminar proveedores'
        ]);

        $compras_index = Permission::create([
            'name' => 'admin.compras.index',
            'description' => 'Ver listado de compras'
        ]);

        $compras_create = Permission::create([
            'name' => 'admin.compras.create',
            'description' => 'Crear compras'
        ]);

        $compras_edit = Permission::create([
            'name' => 'admin.compras.edit',
            'description' => 'Editar compras'
        ]);

        $compras_destroy = Permission::create([
            'name' => 'admin.compras.destroy',
            'description' => 'Eliminar compras'
        ]);

        $salidas_index = Permission::create([
            'name' => 'admin.salidas.index',
            'description' => 'Ver listado de salidas'
        ]);

        $salidas_create = Permission::create([
            'name' => 'admin.salidas.create',
            'description' => 'Crear salidas'
        ]);

        $salidas_edit = Permission::create([
            'name' => 'admin.salidas.edit',
            'description' => 'Editar salidas'
        ]);

        $salidas_destroy = Permission::create([
            'name' => 'admin.salidas.destroy',
            'description' => 'Eliminar salidas'
        ]);

        $users_index = Permission::create([
            'name' => 'admin.users.index',
            'description' => 'Ver listado de usuarios'
        ]);

        $users_create = Permission::create([
            'name' => 'admin.users.create',
            'description' => 'Crear usuarios'
        ]);

        $users_edit = Permission::create([
            'name' => 'admin.users.edit',
            'description' => 'Editar usuarios'
        ]);

        $users_destroy = Permission::create([
            'name' => 'admin.users.destroy',
            'description' => 'Eliminar usuarios'
        ]);

        $roles_index = Permission::create([
            'name' => 'admin.roles.index',
            'description' => 'Ver listado de roles'
        ]);

        $roles_create = Permission::create([
            'name' => 'admin.roles.create',
            'description' => 'Crear roles'
        ]);

        $roles_edit = Permission::create([
            'name' => 'admin.roles.edit',
            'description' => 'Editar roles'
        ]);

        $roles_destroy = Permission::create([
            'name' => 'admin.roles.destroy',
            'description' => 'Eliminar roles'
        ]);

        //asignacion de permisos a roles
        $admin_s->givePermissionTo([
            $categories_index,
            $categories_create,
            $categories_edit,
            $categories_destroy,
            $products_index,
            $products_create,
            $products_edit,
            $products_destroy,
            $providers_index,
            $providers_create,
            $providers_edit,
            $providers_destroy,
            $compras_index,
            $compras_create,
            $compras_edit,
            $compras_destroy,
            $salidas_index,
            $salidas_create,
            $salidas_edit,
            $salidas_destroy,
            $users_index,
            $users_create,
            $users_edit,
            $users_destroy,
            $roles_index,
            $roles_create,
            $roles_edit,
            $roles_destroy,
        ]);

        $admin->givePermissionTo([
            $categories_index,
            $categories_create,
            $categories_edit,
            $categories_destroy,
            $products_index,
            $products_create,
            $products_edit,
            $products_destroy,
            $providers_index,
            $providers_create,
            $providers_edit,
            $providers_destroy,
        ]);

        $soporte->givePermissionTo([
            $providers_index,
            $providers_create,
            $providers_edit,
            $providers_destroy,
            $compras_index,
            $compras_create,
            $compras_edit,
            $compras_destroy,
            $salidas_index,
            $salidas_create,
            $salidas_edit,
            $salidas_destroy,
        ]);
    }
}
