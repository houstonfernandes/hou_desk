<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetorTableSeeder extends Seeder
{
    public function run()
    {

//        DB::table('categories')->truncate();
        factory('App\Setor')->create([
            'nome' => "Supervisão",
            'local_id' => 1
        ]);
        factory('App\Setor')->create([
            'nome' => "RH",
            'local_id' => 1
        ]);
        
        factory('App\Setor')->create([
            'nome' => "Ciência e Tecnologia",
            'local_id' => 1
        ]);        
        
        factory('App\Setor')->create([
            'nome' => "Secretaria",
            'local_id' => 2
        ]);
        
        factory('App\Setor')->create([
            'nome' => "Secretaria",
            'local_id' => 3
        ]);
        
        factory('App\Setor')->create([
            'nome' => "Lab. informática",
            'local_id' => 2
        ]);
        
        factory('App\Setor')->create([
            'nome' => "Sala dos Professores",
            'local_id' => 2
        ]);
        
        
        //factory('App\TipoEquipamento',10)->create();
    }
}