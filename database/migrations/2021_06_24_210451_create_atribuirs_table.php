<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtribuirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atribuirs', function (Blueprint $table) {
            $table->bigIncrements('id_atribuir');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('equip_id')->unsigned();
            $table->string('descricao');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('equip_id')->references('id_equipamento')->on('equipamentos')->onDelete('cascade');
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
        Schema::dropIfExists('atribuirs');
    }
}
