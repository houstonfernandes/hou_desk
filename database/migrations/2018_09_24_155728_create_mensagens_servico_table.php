<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensagensServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensagens_servico', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');//->onDelete('cascade');
            $table->integer('servico_id')->unsigned();
            $table->foreign('servico_id')->references('id')->on('servicos');//->onDelete('cascade');            
            $table->tinyInteger('situacao')->default(0)->nullable();//não lido = 0, lido = 1
            $table->text('mensagem');
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
        Schema::dropIfExists('mensagens_servico');
    }
}
