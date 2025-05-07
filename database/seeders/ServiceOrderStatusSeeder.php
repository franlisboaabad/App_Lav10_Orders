<?php

namespace Database\Seeders;

use App\Models\ServiceOrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceOrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Pendiente',
                'color' => '#ffc107', // Amarillo
                'description' => 'Orden de servicio creada y pendiente de diagnóstico',
                'is_active' => true
            ],
            [
                'name' => 'En Diagnóstico',
                'color' => '#17a2b8', // Azul claro
                'description' => 'El dispositivo está siendo diagnosticado',
                'is_active' => true
            ],
            [
                'name' => 'Esperando Aprobación',
                'color' => '#fd7e14', // Naranja
                'description' => 'Diagnóstico completado, esperando aprobación del cliente',
                'is_active' => true
            ],
            [
                'name' => 'En Reparación',
                'color' => '#007bff', // Azul
                'description' => 'Reparación en proceso',
                'is_active' => true
            ],
            [
                'name' => 'Listo para Entrega',
                'color' => '#28a745', // Verde
                'description' => 'Reparación completada, listo para entrega',
                'is_active' => true
            ],
            [
                'name' => 'Entregado',
                'color' => '#6c757d', // Gris
                'description' => 'Dispositivo entregado al cliente',
                'is_active' => true
            ],
            [
                'name' => 'Cancelado',
                'color' => '#dc3545', // Rojo
                'description' => 'Orden de servicio cancelada',
                'is_active' => true
            ]
        ];

        foreach ($statuses as $status) {
            ServiceOrderStatus::create([
                'name' => $status['name'],
                'slug' => Str::slug($status['name']),
                'color' => $status['color'],
                'description' => $status['description'],
                'is_active' => $status['is_active']
            ]);
        }
    }
}