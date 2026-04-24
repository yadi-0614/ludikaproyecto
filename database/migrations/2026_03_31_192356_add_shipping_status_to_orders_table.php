<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('shipping_status', ['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado'])
                  ->default('pendiente')
                  ->after('status');
            $table->text('shipping_notes')->nullable()->after('shipping_status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_status', 'shipping_notes']);
        });
    }
};
