<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'description' => 'Fabricante de dispositivos iOS y macOS'],
            ['name' => 'Samsung', 'description' => 'Fabricante de dispositivos Android y electrónicos'],
            ['name' => 'Huawei', 'description' => 'Fabricante de smartphones y equipos de red'],
            ['name' => 'Xiaomi', 'description' => 'Fabricante de smartphones y dispositivos IoT'],
            ['name' => 'LG', 'description' => 'Fabricante de electrónicos y electrodomésticos'],
            ['name' => 'Sony', 'description' => 'Fabricante de electrónicos y entretenimiento'],
            ['name' => 'Motorola', 'description' => 'Fabricante de smartphones y equipos de comunicación'],
            ['name' => 'Lenovo', 'description' => 'Fabricante de computadoras y dispositivos móviles'],
            ['name' => 'Asus', 'description' => 'Fabricante de computadoras y componentes'],
            ['name' => 'HP', 'description' => 'Fabricante de computadoras e impresoras'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'is_active' => true
            ]);
        }
    }
}
