<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoEntradaTable extends Migration
{
    public function up()
    {
        Schema::create('documento_entrada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrada_id');
            $table->unsignedBigInteger('documento_id');
            $table->timestamps();

            $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

            $table->unique(['entrada_id', 'documento_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documento_entrada');
    }
}
