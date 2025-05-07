<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::firstOrCreate(['name' => 'admin']);
        User::firstOrCreate(
            ['email' => 'frank@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('secret'),
            ]
        )->assignRole('admin');

        $this->call([
            // Usuarios y Roles
            UserSeeder::class,
            // RoleSeeder::class,
            // PermissionSeeder::class,

            // Empresa
            CompanySeeder::class,

            // Dispositivos
            BrandSeeder::class,
            DeviceTypeSeeder::class,
            DeviceModelSeeder::class,

            // Clientes y Servicios
            CustomerSeeder::class,
            //ServiceOrderSeeder::class,

            // Inventario
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,

            // Caja y Ventas
            //CashRegisterSeeder::class,
            //CashMovementSeeder::class,
            //SaleSeeder::class,
        ]);
    }
}
