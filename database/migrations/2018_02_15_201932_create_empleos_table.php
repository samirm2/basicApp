<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cargo');
            $table->string('descripcion',200);
            $table->string('salario');
            $table->string('tipo_salario');
            $table->string('duracion');
            $table->string('tipo_duracion');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleos');
    }
}
