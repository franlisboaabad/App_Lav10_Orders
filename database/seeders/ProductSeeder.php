<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electrónicos
            [
                'name' => 'Smartphone XYZ',
                'description' => 'Smartphone de última generación',
                'category_id' => 1,
                'supplier_id' => 1,
                'purchase_price' => 800.00,
                'sale_price' => 999.99,
                'stock' => 50,
                'is_active' => true,
                'sku' => 'ELEC-001',
                'code' => 'PROD001'
            ],
            [
                'name' => 'Laptop ABC',
                'description' => 'Laptop para trabajo y entretenimiento',
                'category_id' => 1,
                'supplier_id' => 1,
                'purchase_price' => 1200.00,
                'sale_price' => 1499.99,
                'stock' => 30,
                'is_active' => true,
                'sku' => 'ELEC-002',
                'code' => 'PROD002'
            ],
            [
                'name' => 'Auriculares Bluetooth',
                'description' => 'Auriculares inalámbricos con cancelación de ruido',
                'category_id' => 1,
                'supplier_id' => 1,
                'purchase_price' => 150.00,
                'sale_price' => 199.99,
                'stock' => 100,
                'is_active' => true,
                'sku' => 'ELEC-003',
                'code' => 'PROD003'
            ],

            // Ropa
            [
                'name' => 'Camisa Casual',
                'description' => 'Camisa casual para hombre',
                'category_id' => 2,
                'supplier_id' => 2,
                'purchase_price' => 35.00,
                'sale_price' => 49.99,
                'stock' => 200,
                'is_active' => true,
                'sku' => 'ROPA-001',
                'code' => 'PROD004'
            ],
            [
                'name' => 'Pantalón Jeans',
                'description' => 'Pantalón jeans clásico',
                'category_id' => 2,
                'supplier_id' => 2,
                'purchase_price' => 60.00,
                'sale_price' => 79.99,
                'stock' => 150,
                'is_active' => true,
                'sku' => 'ROPA-002',
                'code' => 'PROD005'
            ],

            // Hogar
            [
                'name' => 'Juego de Ollas',
                'description' => 'Set de 5 ollas antiadherentes',
                'category_id' => 3,
                'supplier_id' => 3,
                'purchase_price' => 250.00,
                'sale_price' => 299.99,
                'stock' => 40,
                'is_active' => true,
                'sku' => 'HOGAR-001',
                'code' => 'PROD006'
            ],
            [
                'name' => 'Lámpara LED',
                'description' => 'Lámpara LED de escritorio',
                'category_id' => 3,
                'supplier_id' => 3,
                'purchase_price' => 30.00,
                'sale_price' => 39.99,
                'stock' => 80,
                'is_active' => true,
                'sku' => 'HOGAR-002',
                'code' => 'PROD007'
            ],

            // Alimentos
            [
                'name' => 'Arroz Premium',
                'description' => 'Bolsa de arroz 5kg',
                'category_id' => 4,
                'supplier_id' => 4,
                'purchase_price' => 20.00,
                'sale_price' => 24.99,
                'stock' => 300,
                'is_active' => true,
                'sku' => 'ALIM-001',
                'code' => 'PROD008'
            ],
            [
                'name' => 'Aceite de Oliva',
                'description' => 'Botella de aceite de oliva extra virgen 1L',
                'category_id' => 4,
                'supplier_id' => 4,
                'purchase_price' => 15.00,
                'sale_price' => 19.99,
                'stock' => 200,
                'is_active' => true,
                'sku' => 'ALIM-002',
                'code' => 'PROD009'
            ],

            // Bebidas
            [
                'name' => 'Agua Mineral',
                'description' => 'Pack de 6 botellas de agua mineral',
                'category_id' => 5,
                'supplier_id' => 5,
                'purchase_price' => 3.50,
                'sale_price' => 4.99,
                'stock' => 500,
                'is_active' => true,
                'sku' => 'BEB-001',
                'code' => 'PROD010'
            ],
            [
                'name' => 'Refresco Cola',
                'description' => 'Pack de 6 latas de refresco',
                'category_id' => 5,
                'supplier_id' => 5,
                'purchase_price' => 4.50,
                'sale_price' => 5.99,
                'stock' => 400,
                'is_active' => true,
                'sku' => 'BEB-002',
                'code' => 'PROD011'
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            $product->inventory()->create([
                'product_id' => $product->id,
                'quantity' => $product->stock,
                'min_stock' => 0,
                'max_stock' => 0
            ]);

        }



    }
}