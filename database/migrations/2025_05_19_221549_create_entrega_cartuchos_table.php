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
        Schema::create('entrega_cartuchos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_id');
            $table->date('fecha_asignacion');
            $table->string('motivo_entrega');
            $table->date('fecha_entrega');
            $table->unsignedBigInteger('personal_entrego');
            $table->unsignedBigInteger('personal_recibio');
            $table->unsignedBigInteger('personal_autorizo');
            $table->string('unidad')->nullable();
            $table->string('area')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            $table->foreign('personal_entrego')->references('id')->on('users');
            $table->foreign('personal_recibio')->references('id')->on('colaboradores');
            $table->foreign('personal_autorizo')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_cartuchos');
    }
};
