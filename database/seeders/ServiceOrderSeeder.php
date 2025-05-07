<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder;
use App\Models\Customer;
use App\Models\DeviceModel;
use App\Models\User;
use Illuminate\Support\Str;

class ServiceOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener algunos clientes y modelos para las órdenes
        $customers = Customer::all();
        $deviceModels = DeviceModel::all();

        $orders = [
            [
                'customer_id' => 1,
                'device_model_id' => 1,
                'user_id' => 1,
                'code' => 'OS-001',
                'description' => 'Pantalla rota, no enciende',
                'diagnosis' => 'Pantalla LCD dañada, requiere reemplazo',
                'solution' => 'Reemplazo de pantalla LCD',
                'status' => 'completed',
                'total' => 150.00,
                'created_at' => now()->subDays(5)
            ],
            [
                'customer_id' => 2,
                'device_model_id' => 4,
                'user_id' => 1,
                'code' => 'OS-002',
                'description' => 'No carga la batería',
                'diagnosis' => 'Conector de carga dañado',
                'solution' => 'Reemplazo de conector de carga',
                'status' => 'in_progress',
                'total' => 80.00,
                'created_at' => now()->subDays(2)
            ],
            [
                'customer_id' => 3,
                'device_model_id' => 6,
                'user_id' => 1,
                'code' => 'OS-003',
                'description' => 'Problemas con el audio',
                'diagnosis' => 'Altavoz principal dañado',
                'solution' => 'Reemplazo de altavoz',
                'status' => 'pending',
                'total' => 60.00,
                'created_at' => now()
            ]
        ];

        foreach ($orders as $order) {
            ServiceOrder::create($order);
        }
    }
}
