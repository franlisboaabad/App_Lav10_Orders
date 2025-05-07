<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);

        // Crear usuario vendedor
        User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@example.com',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);
    }
}
