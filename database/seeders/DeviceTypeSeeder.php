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
            ['name' => 'Smartphone','slug' => 'smartphone', 'is_active' => true],
            ['name' => 'Tablet', 'slug' => 'tablet', 'is_active' => true],
            ['name' => 'Laptop', 'slug' => 'laptop', 'is_active' => true],
            ['name' => 'Desktop', 'slug' => 'desktop', 'is_active' => true],
            ['name' => 'Smartwatch', 'slug' => 'smartwatch', 'is_active' => true],
            ['name' => 'Smart TV', 'slug' => 'smart-tv', 'is_active' => true],
            ['name' => 'Impresora', 'slug' => 'impresora', 'is_active' => true],
            ['name' => 'Router', 'slug' => 'router', 'is_active' => true],
            ['name' => 'Cámara', 'slug' => 'camara', 'is_active' => true],
            ['name' => 'Otro', 'slug' => 'otro', 'is_active' => true]
        ];

        foreach ($types as $type) {
            DeviceType::create($type);
        }
    }
}
