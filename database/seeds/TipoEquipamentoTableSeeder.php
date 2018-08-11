<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEquipamentoTableSeeder extends Seeder
{
    public function run()
    {

//        DB::table('categories')->truncate();
        factory('App\TipoEquipamento')->create([
            'nome' => "Computador",
        ]);        
        factory('App\TipoEquipamento')->create([
            'nome' => "Celular",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Televisão",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Televisão Smarty",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Tablet",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Data show",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "DVD player",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Lousa eletrônica",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Roteador rede",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Switch rede",
        ]);
        factory('App\TipoEquipamento')->create([
            'nome' => "Mesa de som",
        ]);
        //factory('App\TipoEquipamento',10)->create();
    }
}