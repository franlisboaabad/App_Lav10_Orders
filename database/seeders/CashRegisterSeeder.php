<?php

namespace Database\Seeders;

use App\Models\CashRegister;
use App\Models\User;
use Illuminate\Database\Seeder;

class CashRegisterSeeder extends Seeder
{
    public function run(): void
    {
        CashRegister::create([
            'user_id' => 1,
            'initial_amount' => 1000.00,
            'current_amount' => 1000.00,
            'status' => 'open',
            'opened_at' => now()->subDay(),
            'closed_at' => null
        ]);
    }
}
