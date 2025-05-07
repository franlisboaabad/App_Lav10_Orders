<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Acceso total al sistema'
            ],
            [
                'name' => 'Vendedor',
                'slug' => 'seller',
                'description' => 'Acceso a ventas y caja'
            ],
            [
                'name' => 'Técnico',
                'slug' => 'technician',
                'description' => 'Acceso a órdenes de servicio'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
