<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeviceModel;
use App\Models\Brand;
use App\Models\DeviceType;
use Illuminate\Support\Str;

class DeviceModelSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de marcas y tipos
        $apple = Brand::where('name', 'Apple')->first();
        $samsung = Brand::where('name', 'Samsung')->first();
        $huawei = Brand::where('name', 'Huawei')->first();

        $smartphone = DeviceType::where('name', 'Smartphone')->first();
        $laptop = DeviceType::where('name', 'Laptop')->first();
        $tablet = DeviceType::where('name', 'Tablet')->first();

        $models = [
            // Apple
            [
                'brand_id' => $apple->id,
                'device_type_id' => $smartphone->id,
                'name' => 'iPhone 14 Pro',
                'description' => 'Smartphone de gama alta con cámara de 48MP'
            ],
            [
                'brand_id' => $apple->id,
                'device_type_id' => $laptop->id,
                'name' => 'MacBook Pro M2',
                'description' => 'Laptop profesional con chip M2'
            ],
            [
                'brand_id' => $apple->id,
                'device_type_id' => $tablet->id,
                'name' => 'iPad Pro',
                'description' => 'Tablet profesional con pantalla Liquid Retina'
            ],

            // Samsung
            [
                'brand_id' => $samsung->id,
                'device_type_id' => $smartphone->id,
                'name' => 'Galaxy S23 Ultra',
                'description' => 'Smartphone insignia con cámara de 200MP'
            ],
            [
                'brand_id' => $samsung->id,
                'device_type_id' => $tablet->id,
                'name' => 'Galaxy Tab S9',
                'description' => 'Tablet Android de gama alta'
            ],

            // Huawei
            [
                'brand_id' => $huawei->id,
                'device_type_id' => $smartphone->id,
                'name' => 'P60 Pro',
                'description' => 'Smartphone con sistema de cámara avanzado'
            ],
            [
                'brand_id' => $huawei->id,
                'device_type_id' => $laptop->id,
                'name' => 'MateBook X Pro',
                'description' => 'Laptop ultradelgada con pantalla táctil'
            ],
        ];

        foreach ($models as $model) {
            DeviceModel::create([
                'brand_id' => $model['brand_id'],
                'device_type_id' => $model['device_type_id'],
                'name' => $model['name'],
                'slug' => Str::slug($model['name']),
                'description' => $model['description'],
                'is_active' => true
            ]);
        }
    }
}
