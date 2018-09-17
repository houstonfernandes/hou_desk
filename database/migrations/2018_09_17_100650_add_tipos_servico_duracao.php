<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTiposServicoDuracao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_servico', function (Blueprint $table) {
            $table->integer('duracao')->unsigned();
            $table->char('duracao_unidade', 1);//D H M
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_servico', function (Blueprint $table) {
            $table->dropColumn([
                'duracao', 'duracao_unidade'                
            ]);          
        });
    }
}
