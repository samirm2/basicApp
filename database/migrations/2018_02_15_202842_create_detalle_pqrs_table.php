<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pqrs', function (Blueprint $table) {
            $table->integer('pqrs_id')->unsigned();
            $table->string('mensaje',500);
            $table->unsignedInteger('autor');
            $table->timestamps();

            $table->foreign('pqrs_id')->references('id')->on('pqrs');
            $table->foreign('autor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_pqrs');
    }
}
