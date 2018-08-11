<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('nome', 80);
            $table->string('marca', 80)->nullable();
            $table->text('descricao')->nullable();
            $table->integer('num_patrimonio')->nullable();
            $table->integer('num_etiqueta')->nullable();
            $table->timestamp('data_aquisicao')->nullable();
            $table->decimal('custo',10,2)->nullable()->default(0);
            $table->string('origem',100)->nullable();
            $table->tinyInteger('situacao')->default(1);            
            $table->integer('tipo_equipamento_id')->unsigned();
            $table->foreign('tipo_equipamento_id')->references('id')->on('tipos_equipamento');//->onDelete('cascade');
            $table->integer('setor_id')->unsigned();
            $table->foreign('setor_id')->references('id')->on('setores');//->onDelete('cascade');
            $table->timestamps();
//            $table->string('cod_barra', 13)->nullable();
//            $table->float('qtd')->default(0);
//            $table->float('qtd_min')->unsigned()->nullable();
//            $table->float('qtd_max')->unsigned()->nullable();
//            $table->string('unidade', 60)->default('un');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('equipamentos');
    }
}
