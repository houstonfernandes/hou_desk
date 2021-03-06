<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposEquipamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_equipamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',80);
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
 //           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipos_equipamento');
    }
}
