<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['entry', 'exit', 'adjustment']);
            $table->integer('quantity');
            $table->integer('previous_quantity');
            $table->integer('current_quantity');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Índices
            $table->index('inventory_id');
            $table->index(['reference_type', 'reference_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
};
