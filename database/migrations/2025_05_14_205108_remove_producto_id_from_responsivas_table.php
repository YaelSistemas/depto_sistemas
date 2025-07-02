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
        Schema::table('responsivas', function (Blueprint $table) {
            $table->dropForeign(['producto_id']); // elimina la FK
            $table->dropColumn('producto_id');    // elimina la columna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsivas', function (Blueprint $table) {
            $table->unsignedBigInteger('producto_id')->nullable();

            // Si quieres restaurar la FK también
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
};
