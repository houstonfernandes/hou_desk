<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicoTableSeeder extends Seeder
{
    public function run()
    {

//        DB::table('categories')->truncate();
        factory('App\TipoServico')->create([
            'nome' => "Reparo",
        ]);        
        factory('App\TipoServico')->create([
            'nome' => "Retirada",
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Visita técnica",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Instalaçao",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Instalaçao de software",
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Instalação de Hardware",
        ]);
        //factory('App\TipoEquipamento',10)->create();
    }
}