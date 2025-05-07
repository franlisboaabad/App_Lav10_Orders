<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear permisos
        $permissions = $this->getPermissions();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $rolePermissions = $this->getRolePermissions();
        foreach ($rolePermissions as $role => $perms) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);
            $roleInstance->syncPermissions($perms);
        }
    }

    private function getPermissions(): array
    {
        return [
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
        ];
    }

    private function getRolePermissions(): array
    {
        return [
            'admin' => [
                'ver usuarios',
                'crear usuarios',
                'editar usuarios',
                'eliminar usuarios',
            ],
            'user' => [
                'ver usuarios',
            ],
        ];
    }
}
