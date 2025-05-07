<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Mi Empresa',
            'ruc' => '20123456789',
            'address' => 'Av. Principal 123',
            'phone' => '987654321',
            'email' => 'contacto@miempresa.com',
            'logo' => 'logo.png',
            'description' => 'Descripción de mi empresa',
        ]);
    }
}
