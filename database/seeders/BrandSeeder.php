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
            ['name' => 'Apple', 'slug' => 'apple', 'is_active' => true],
            ['name' => 'Samsung', 'slug' => 'samsung', 'is_active' => true],
            ['name' => 'Huawei', 'slug' => 'huawei', 'is_active' => true],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi', 'is_active' => true],
            ['name' => 'Motorola', 'slug' => 'motorola', 'is_active' => true],
            ['name' => 'LG', 'slug' => 'lg', 'is_active' => true],
            ['name' => 'Sony', 'slug' => 'sony', 'is_active' => true],
            ['name' => 'Asus', 'slug' => 'asus', 'is_active' => true],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'is_active' => true],
            ['name' => 'HP', 'slug' => 'hp', 'is_active' => true]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
