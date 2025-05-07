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
        Schema::create('area_departamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID del usuario creador
            $table->unsignedBigInteger('empresa_id'); // Relación con empresas
            $table->unsignedBigInteger('unidad_servicio_id'); // Relación con unidad_servicios
            $table->string('nombre'); // Nombre del área/departamento
            $table->timestamps();

            // Claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('unidad_servicio_id')->references('id')->on('unidad_servicios')->onDelete('cascade');

            // Restricción única compuesta
            $table->unique(['nombre', 'unidad_servicio_id', 'empresa_id'], 'area_unica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_departamentos');
    }
};
