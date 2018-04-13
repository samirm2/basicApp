<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqrs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asunto');
            $table->string('tipo');
            $table->string('estado')->default('Activo');
            $table->unsignedInteger('destinatario');
            $table->unsignedInteger('remitente');
            $table->timestamps();

            $table->foreign('tipo')->references('nombre')->on('tipo_pqrs');
            $table->foreign('destinatario')->references('id')->on('personas');
            $table->foreign('remitente')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pqrs');
    }
}
