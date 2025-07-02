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
        Schema::create('responsivas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero_salida')->default(1); // nuevo campo
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->onDelete('restrict');
            $table->integer('cantidad_asignada')->default(1);
            $table->date('fecha_asignacion')->nullable(); // Si es opcional
            $table->string('estatus')->default('activa'); // Si lo estás usando

            // Nuevos campos
            $table->string('motivo_entrega')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->string('personal_entrego')->nullable();
            $table->string('personal_recibio')->nullable();
            $table->string('personal_autorizo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsivas');
    }
};
