<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('min_stock')->default(0);
            $table->integer('max_stock')->default(0);
            $table->timestamps();

            // Índices
            $table->index('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
