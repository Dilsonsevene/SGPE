<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->bigIncrements('id_equipamento');
            $table->string('codigo_equipamento');
            $table->string('referencia');
            $table->string('estado_conputador');
            $table->string('necessario');
            $table->bigInteger('sector_id')->unsigned();
            $table->bigInteger('tipo_id')->unsigned();
            $table->foreign('sector_id')->references('id_sector')->on('sectors')->onDelete('cascade');
            $table->foreign('tipo_id')->references('id_eptp')->on('equipamento__tipos')->onDelete('cascade');
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
        Schema::dropIfExists('equipamentos');
    }
}
