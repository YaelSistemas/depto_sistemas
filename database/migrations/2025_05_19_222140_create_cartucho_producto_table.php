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
        Schema::create('cartucho_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrega_cartucho_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad_asignada');
            $table->timestamps();

            $table->foreign('entrega_cartucho_id')->references('id')->on('entrega_cartuchos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartucho_producto');
    }
};
