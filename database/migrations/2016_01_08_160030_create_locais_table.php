<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('nome_fantasia',100)->nullable();
            $table->string('cnpj', 18)->nullable();//cpf ou cnpj
            $table->string('inep', 18)->nullable();//cpf ou cnpj
            $table->string('endereco', 120)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf',2)->nullable();
            $table->string('ponto_ref')->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('complemento')->nullable();
            $table->string('tel',14)->nullable();
            $table->string('cel',14)->nullable();
            $table->string('email')->nullable();
            $table->text('obs')->nullable();
            $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('locais');
    }
}
