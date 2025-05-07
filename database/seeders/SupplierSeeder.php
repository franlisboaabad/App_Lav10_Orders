<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'ElectroTech S.A.',
                'document_type' => 'RUC',
                'document_number' => '20123456789',
                'address' => 'Av. Industrial 123',
                'phone' => '01-1234567',
                'email' => 'contacto@electrotech.com',
                'is_active' => true
            ],
            [
                'name' => 'Moda Express',
                'document_type' => 'RUC',
                'document_number' => '20123456790',
                'address' => 'Av. La Marina 456',
                'phone' => '01-7654321',
                'email' => 'ventas@modaexpress.com',
                'is_active' => true
            ],
            [
                'name' => 'Hogar Center',
                'document_type' => 'RUC',
                'document_number' => '20123456791',
                'address' => 'Av. Primavera 789',
                'phone' => '01-9876543',
                'email' => 'info@hogarcenter.com',
                'is_active' => true
            ],
            [
                'name' => 'Distribuidora de Alimentos',
                'document_type' => 'RUC',
                'document_number' => '20123456792',
                'address' => 'Av. Los Olivos 321',
                'phone' => '01-4567890',
                'email' => 'ventas@distribuidora.com',
                'is_active' => true
            ],
            [
                'name' => 'Bebidas del Norte',
                'document_type' => 'RUC',
                'document_number' => '20123456793',
                'address' => 'Av. Túpac Amaru 654',
                'phone' => '01-2345678',
                'email' => 'contacto@bebidasnorte.com',
                'is_active' => true
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
