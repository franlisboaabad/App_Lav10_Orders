<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónicos',
                'description' => 'Productos electrónicos y gadgets',
                'is_active' => true
            ],
            [
                'name' => 'Ropa',
                'description' => 'Ropa y accesorios',
                'is_active' => true
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar',
                'is_active' => true
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios',
                'is_active' => true
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Bebidas y refrescos',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
