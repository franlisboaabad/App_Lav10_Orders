<?php

namespace Database\Seeders;

use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\User;
use Illuminate\Database\Seeder;

class CashMovementSeeder extends Seeder
{
    public function run(): void
    {
        $movements = [
            [
                'cash_register_id' => 1,
                'user_id' => 1,
                'type' => 'sale',
                'amount' => 150.00,
                'description' => 'Venta de accesorios',
                'created_at' => now()->subHours(2)
            ],
            [
                'cash_register_id' => 1,
                'user_id' => 1,
                'type' => 'expense',
                'amount' => -50.00,
                'description' => 'Compra de repuestos',
                'created_at' => now()->subHour()
            ],
            [
                'cash_register_id' => 1,
                'user_id' => 1,
                'type' => 'sale',
                'amount' => 80.00,
                'description' => 'Venta de servicio técnico',
                'created_at' => now()
            ]
        ];

        foreach ($movements as $movement) {
            CashMovement::create($movement);
        }
    }
}
