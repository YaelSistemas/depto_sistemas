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
        Schema::table('unidad_servicios', function (Blueprint $table) {
            $table->foreign('colaborador_id')
                ->references('id')
                ->on('colaboradores')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidad_servicios', function (Blueprint $table) {
            $table->dropForeign(['colaborador_id']);
        });
    }
};
