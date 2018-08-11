<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('solicitante_id')->unsigned();
            $table->foreign('solicitante_id')->references('id')->on('users');//->onDelete('cascade');
            $table->integer('executor_id')->unsigned()->nullable();
            $table->foreign('executor_id')->references('id')->on('users');//->onDelete('cascade');
            
            $table->integer('equipamento_id')->unsigned();
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');//->onDelete('cascade');
            
            $table->integer('tipo_servico_id')->unsigned();
            $table->foreign('tipo_servico_id')->references('id')->on('tipos_servico');//->onDelete('cascade');
            
            $table->text('descricao');
            $table->text('solucao')->nullable();//msg quando resolver
            $table->tinyInteger('situacao')->default(0);            
            $table->timestamp('data_solucao')->nullable();
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
        Schema::dropIfExists('servicos');
    }
}
