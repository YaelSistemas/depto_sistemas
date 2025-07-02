<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->date('fecha_compra')->nullable()->after('capacidad_almacenamiento');
            $table->json('orden_compra')->nullable()->after('fecha_compra');
            $table->json('factura')->nullable()->after('orden_compra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['fecha_compra', 'orden_compra', 'factura']);
        });
    }
};
