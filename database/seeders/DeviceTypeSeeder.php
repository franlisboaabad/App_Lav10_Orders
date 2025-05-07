<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeviceType;
use Illuminate\Support\Str;

class DeviceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Smartphone', 'description' => 'Teléfonos móviles inteligentes'],
            ['name' => 'Tablet', 'description' => 'Dispositivos táctiles portátiles'],
            ['name' => 'Laptop', 'description' => 'Computadoras portátiles'],
            ['name' => 'Desktop', 'description' => 'Computadoras de escritorio'],
            ['name' => 'Smart TV', 'description' => 'Televisores con conectividad'],
            ['name' => 'Smartwatch', 'description' => 'Relojes inteligentes'],
            ['name' => 'Impresora', 'description' => 'Dispositivos de impresión'],
            ['name' => 'Router', 'description' => 'Dispositivos de red'],
            ['name' => 'Cámara', 'description' => 'Cámaras digitales y de video'],
            ['name' => 'Consola', 'description' => 'Consolas de videojuegos'],
        ];

        foreach ($types as $type) {
            DeviceType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']),
                'description' => $type['description'],
                'is_active' => true
            ]);
        }
    }
}
