<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->foreignId('specialist_id')
                  ->nullable()
                  ->after('customer_id')
                  ->constrained('specialists')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropForeign(['specialist_id']);
            $table->dropColumn('specialist_id');
        });
    }
};
