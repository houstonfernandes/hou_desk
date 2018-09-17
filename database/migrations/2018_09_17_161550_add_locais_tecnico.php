<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocaisTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locais', function (Blueprint $table) {
            $table->integer('tecnico_id')->unsigned()->nullable();
            $table->foreign('tecnico_id')->references('id')->on('users');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locais', function (Blueprint $table) {
            $table->dropColumn([
                'tecnico_id'                
            ]);          
        });
    }
}
