<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@email.com',
                'phone' => '555-0101',
                'address' => 'Calle Principal 123, Ciudad',
                'document_type' => 'DNI',
                'document_number' => '12345678',
                'notes' => 'Cliente frecuente'
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@email.com',
                'phone' => '555-0102',
                'address' => 'Avenida Central 456, Ciudad',
                'document_type' => 'DNI',
                'document_number' => '87654321',
                'notes' => 'Prefiere servicio express'
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos.lopez@email.com',
                'phone' => '555-0103',
                'address' => 'Plaza Mayor 789, Ciudad',
                'document_type' => 'RUC',
                'document_number' => '20123456789',
                'notes' => 'Cliente empresarial'
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@email.com',
                'phone' => '555-0104',
                'address' => 'Calle Secundaria 321, Ciudad',
                'document_type' => 'DNI',
                'document_number' => '23456789',
                'notes' => 'Nuevo cliente'
            ],
            [
                'name' => 'Roberto Sánchez',
                'email' => 'roberto.sanchez@email.com',
                'phone' => '555-0105',
                'address' => 'Avenida Norte 654, Ciudad',
                'document_type' => 'RUC',
                'document_number' => '20234567890',
                'notes' => 'Cliente VIP'
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create([
                'name' => $customer['name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
                'address' => $customer['address'],
                'document_type' => $customer['document_type'],
                'document_number' => $customer['document_number'],
                'notes' => $customer['notes'],
                'is_active' => true
            ]);
        }
    }
}
