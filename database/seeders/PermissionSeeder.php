<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Usuarios
            [
                'name' => 'Ver Usuarios',
                'slug' => 'users.view',
                'description' => 'Permite ver la lista de usuarios'
            ],
            [
                'name' => 'Crear Usuarios',
                'slug' => 'users.create',
                'description' => 'Permite crear nuevos usuarios'
            ],
            [
                'name' => 'Editar Usuarios',
                'slug' => 'users.edit',
                'description' => 'Permite editar usuarios existentes'
            ],
            [
                'name' => 'Eliminar Usuarios',
                'slug' => 'users.delete',
                'description' => 'Permite eliminar usuarios'
            ],

            // Ventas
            [
                'name' => 'Ver Ventas',
                'slug' => 'sales.view',
                'description' => 'Permite ver la lista de ventas'
            ],
            [
                'name' => 'Crear Ventas',
                'slug' => 'sales.create',
                'description' => 'Permite crear nuevas ventas'
            ],
            [
                'name' => 'Anular Ventas',
                'slug' => 'sales.cancel',
                'description' => 'Permite anular ventas'
            ],

            // Caja
            [
                'name' => 'Ver Caja',
                'slug' => 'cash.view',
                'description' => 'Permite ver el estado de caja'
            ],
            [
                'name' => 'Abrir Caja',
                'slug' => 'cash.open',
                'description' => 'Permite abrir caja'
            ],
            [
                'name' => 'Cerrar Caja',
                'slug' => 'cash.close',
                'description' => 'Permite cerrar caja'
            ],

            // Órdenes de Servicio
            [
                'name' => 'Ver Órdenes',
                'slug' => 'service-orders.view',
                'description' => 'Permite ver la lista de órdenes'
            ],
            [
                'name' => 'Crear Órdenes',
                'slug' => 'service-orders.create',
                'description' => 'Permite crear nuevas órdenes'
            ],
            [
                'name' => 'Editar Órdenes',
                'slug' => 'service-orders.edit',
                'description' => 'Permite editar órdenes existentes'
            ],
            [
                'name' => 'Eliminar Órdenes',
                'slug' => 'service-orders.delete',
                'description' => 'Permite eliminar órdenes'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
