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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nombre');
            $table->string('apellido');
            $table->string('puesto')->nullable();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('unidad_servicio_id')->nullable();
            $table->unsignedBigInteger('area_departamento_id')->nullable();

            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('unidad_servicio_id')->references('id')->on('unidad_servicios')->onDelete('set null');
            $table->foreign('area_departamento_id')->references('id')->on('area_departamentos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
