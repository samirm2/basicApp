<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleoAspirantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleo_aspirantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cc')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email');
            $table->string('hoja_vida');
            $table->integer('empleo_id')->unsigned();
            $table->timestamps();

            $table->foreign('empleo_id')->references('id')->on('empleos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleo_aspirantes');
    }
}
