<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->boolean('enabled')->default(true);
            $table->string('cpf', 14)->nullable();
            $table->string('endereco', 120)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf',2)->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('tel',14)->nullable();
            $table->string('cel',14)->nullable();
            $table->integer('local_id')->unsigned();
            $table->foreign('local_id')->references('id')->on('locais');//->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_admin', 'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'uf','tel', 'cel'                
            ]);          
        });
    }
}
