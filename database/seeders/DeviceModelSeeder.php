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
        $models = [
            // Apple
            [
                'brand_id' => 1, // Apple
                'device_type_id' => 1, // Smartphone
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'is_active' => true
            ],
            [
                'brand_id' => 1,
                'device_type_id' => 2, // Tablet
                    'name' => 'iPad Pro',
                'slug' => 'ipad-pro',
                'is_active' => true
            ],
            [
                'brand_id' => 1,
                'device_type_id' => 3, // Laptop
                'name' => 'MacBook Pro',
                'slug' => 'macbook-pro',
                'is_active' => true
            ],

            // Samsung
            [
                'brand_id' => 2, // Samsung
                'device_type_id' => 1,
                'name' => 'Galaxy S23',
                'slug' => 'galaxy-s23',
                'is_active' => true
            ],
            [
                'brand_id' => 2,
                'device_type_id' => 2,
                'name' => 'Galaxy Tab S9',
                'slug' => 'galaxy-tab-s9',
                'is_active' => true
            ],

            // Huawei
            [
                'brand_id' => 3, // Huawei
                'device_type_id' => 1,
                'name' => 'P60 Pro',
                'slug' => 'p60-pro',
                'is_active' => true
            ],
            [
                'brand_id' => 3,
                'device_type_id' => 3,
                'name' => 'MateBook X Pro',
                'slug' => 'matebook-x-pro',
                'is_active' => true
            ],

            // Xiaomi
            [
                'brand_id' => 4, // Xiaomi
                'device_type_id' => 1,
                'name' => 'Redmi Note 11',
                'slug' => 'redmi-note-11',
                'is_active' => true
            ]
        ];

        foreach ($models as $model) {
            DeviceModel::create($model);
        }
    }
}
