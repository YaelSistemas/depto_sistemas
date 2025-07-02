<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            DB::statement("ALTER TABLE productos MODIFY COLUMN tipo_almacenamiento ENUM('Disco Duro', 'SSD', 'M.2') NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            DB::statement("ALTER TABLE productos MODIFY COLUMN tipo_almacenamiento ENUM('Disco Duro', 'SSD', 'M2') NULL");
        });;
    }
};
