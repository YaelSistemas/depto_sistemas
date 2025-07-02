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
        Schema::table('entrega_cartuchos', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_autorizo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrega_cartuchos', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_autorizo')->nullable(false)->change();
        });
    }
};
