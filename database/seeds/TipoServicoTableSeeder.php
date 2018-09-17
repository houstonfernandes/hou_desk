<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicoTableSeeder extends Seeder
{
    public function run()
    {
//        DB::table('categories')->truncate();
        factory('App\TipoServico')->create([
            'nome' => "Reparo",'duracao' => 2,'duracao_unidade'=>'d'
        ]);        
        factory('App\TipoServico')->create([
            'nome' => "Retirada",'duracao' => 3,'duracao_unidade'=>'d'
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Visita técnica",'duracao' => 3,'duracao_unidade'=>'h'
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Instalaçao",'duracao' => 2,'duracao_unidade'=>'h'
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Instalaçao de software", 'duracao' => 2,'duracao_unidade'=>'h'
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Instalação de Hardware", 'duracao' => 1,'duracao_unidade'=>'d'
        ]);
        factory('App\TipoServico')->create([
            'nome' => "Reinstalar sistema", 'duracao' => 3,'duracao_unidade'=>'d'
        ]);
        
        factory('App\TipoServico')->create([
            'nome' => "Mudança de local", 'duracao' => 2,'duracao_unidade'=>'h'
        ]);
        
        //factory('App\TipoEquipamento',10)->create();
    }
}