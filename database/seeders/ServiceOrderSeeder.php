<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder;
use App\Models\Customer;
use App\Models\DeviceModel;
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
                'customer_id' => $customers->random()->id,
                'device_model_id' => $deviceModels->random()->id,
                'serial_number' => 'SN' . Str::random(8),
                'problem_description' => 'Pantalla rota, necesita reemplazo',
                'diagnosis' => 'Cristal de pantalla dañado, requiere reemplazo completo',
                'solution' => 'Reemplazo de pantalla LCD y cristal',
                'estimated_cost' => 150.00,
                'final_cost' => 145.00,
                'status' => 'DELIVERED',
                'estimated_delivery_date' => now()->subDays(2),
                'delivery_date' => now()->subDay(),
                'notes' => 'Cliente satisfecho con la reparación'
            ],
            [
                'customer_id' => $customers->random()->id,
                'device_model_id' => $deviceModels->random()->id,
                'serial_number' => 'SN' . Str::random(8),
                'problem_description' => 'No enciende, posible problema de batería',
                'diagnosis' => 'Batería defectuosa, requiere reemplazo',
                'solution' => null,
                'estimated_cost' => 80.00,
                'final_cost' => null,
                'status' => 'WAITING_APPROVAL',
                'estimated_delivery_date' => now()->addDays(2),
                'delivery_date' => null,
                'notes' => 'Esperando aprobación del cliente'
            ],
            [
                'customer_id' => $customers->random()->id,
                'device_model_id' => $deviceModels->random()->id,
                'serial_number' => 'SN' . Str::random(8),
                'problem_description' => 'Problemas con la cámara, fotos borrosas',
                'diagnosis' => null,
                'solution' => null,
                'estimated_cost' => 100.00,
                'final_cost' => null,
                'status' => 'IN_DIAGNOSIS',
                'estimated_delivery_date' => now()->addDays(3),
                'delivery_date' => null,
                'notes' => 'En proceso de diagnóstico'
            ],
            [
                'customer_id' => $customers->random()->id,
                'device_model_id' => $deviceModels->random()->id,
                'serial_number' => 'SN' . Str::random(8),
                'problem_description' => 'Problemas de conectividad WiFi',
                'diagnosis' => 'Módulo WiFi dañado',
                'solution' => 'Reemplazo del módulo WiFi',
                'estimated_cost' => 120.00,
                'final_cost' => 120.00,
                'status' => 'READY',
                'estimated_delivery_date' => now()->addDay(),
                'delivery_date' => null,
                'notes' => 'Listo para entrega'
            ],
            [
                'customer_id' => $customers->random()->id,
                'device_model_id' => $deviceModels->random()->id,
                'serial_number' => 'SN' . Str::random(8),
                'problem_description' => 'Problemas con el puerto de carga',
                'diagnosis' => 'Puerto de carga dañado por humedad',
                'solution' => null,
                'estimated_cost' => 90.00,
                'final_cost' => null,
                'status' => 'IN_REPAIR',
                'estimated_delivery_date' => now()->addDays(2),
                'delivery_date' => null,
                'notes' => 'En proceso de reparación'
            ],
        ];

        foreach ($orders as $order) {
            ServiceOrder::create([
                'code' => 'OS-' . strtoupper(Str::random(8)),
                'customer_id' => $order['customer_id'],
                'device_model_id' => $order['device_model_id'],
                'serial_number' => $order['serial_number'],
                'problem_description' => $order['problem_description'],
                'diagnosis' => $order['diagnosis'],
                'solution' => $order['solution'],
                'estimated_cost' => $order['estimated_cost'],
                'final_cost' => $order['final_cost'],
                'status' => $order['status'],
                'estimated_delivery_date' => $order['estimated_delivery_date'],
                'delivery_date' => $order['delivery_date'],
                'notes' => $order['notes'],
                'is_active' => true
            ]);
        }
    }
}
