<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->decimal('initial_balance', 10, 2);
            $table->decimal('final_balance', 10, 2)->nullable();
            $table->decimal('total_income', 10, 2)->default(0);
            $table->decimal('total_expense', 10, 2)->default(0);
            $table->enum('status', ['OPEN', 'CLOSED'])->default('OPEN');
            $table->dateTime('opening_date');
            $table->dateTime('closing_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};