<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('responsivas', function (Blueprint $table) {
            $table->string('unidad_servicio')->nullable();
            $table->string('area_departamento')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('responsivas', function (Blueprint $table) {
            $table->dropColumn(['unidad_servicio', 'area_departamento']);
        });
    }
};
