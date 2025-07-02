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
            $table->string('ram')->nullable();
            $table->string('procesador')->nullable();
            $table->enum('tipo_almacenamiento', ['Disco Duro', 'SSD', 'M2'])->nullable();
            $table->string('capacidad_almacenamiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['ram', 'procesador', 'tipo_almacenamiento', 'capacidad_almacenamiento']);
        });
    }
};
