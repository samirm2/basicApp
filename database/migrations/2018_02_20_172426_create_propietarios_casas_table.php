<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropietariosCasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propietarios_casas', function (Blueprint $table) {
            $table->integer('casa')->unsigned()->primary();
            $table->integer('propietario_id')->unsigned();
            $table->timestamps();
            $table->foreign('casa')->references('id')->on('casas');
            $table->foreign('propietario_id')->references('id')->on('propietarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propietarios_casas');
    }
}
