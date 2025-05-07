<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $sales = [
            [
                'customer_id' => 1,
                'user_id' => 1,
                'code' => 'V-001',
                'subtotal' => 150.00,
                'tax' => 27.00,
                'total' => 177.00,
                'status' => 'completed',
                'payment_method' => 'cash',
                'created_at' => now()->subDays(2)
            ],
            [
                'customer_id' => 2,
                'user_id' => 1,
                'code' => 'V-002',
                'subtotal' => 80.00,
                'tax' => 14.40,
                'total' => 94.40,
                'status' => 'completed',
                'payment_method' => 'card',
                'created_at' => now()->subDay()
            ],
            [
                'customer_id' => 3,
                'user_id' => 1,
                'code' => 'V-003',
                'subtotal' => 200.00,
                'tax' => 36.00,
                'total' => 236.00,
                'status' => 'pending',
                'payment_method' => 'transfer',
                'created_at' => now()
            ]
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
}
