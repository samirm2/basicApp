<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('casa_id');
            $table->unsignedInteger('mes_id');
            $table->string('valor');
            $table->string('estado')->default('Pendiente');
            $table->datetime('fecha_pago')->nullable();
            $table->timestamps();
            //foreign
            $table->foreign('casa_id')->references('id')->on('casas');
            $table->foreign('mes_id')->references('id')->on('meses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
