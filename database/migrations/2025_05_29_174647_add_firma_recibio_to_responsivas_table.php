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
            $table->string('firma_recibio')->nullable()->after('personal_recibio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsivas', function (Blueprint $table) {
            $table->dropColumn('firma_recibio');
        });
    }
};
