<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponenteTableSeeder extends Seeder
{
    public function run()
    {

//        DB::table('categories')->truncate();
        factory('App\Componente')->create([
            'nome' => "Leitor de DVD",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Monitor 15\"",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Gravador de DVD",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Caixa de som portátil",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Fone de ouvido",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Memoria ddr2",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Memória ddr3",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Placa de vídeo 512MB",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Placa de vídeo 256MB",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Placa de vídeo 128MB",
            'tipo_equipamento_id' => 1
        ]);
        
        factory('App\Componente')->create([
            'nome' => "Placa de vídeo 1GB",
            'tipo_equipamento_id' => 1
        ]);
        factory('App\Componente')->create([
            'nome' => "Placa de vídeo 2GB",
            'tipo_equipamento_id' => 1
        ]);
        
        factory('App\Componente')->create([
            'nome' => "Estabilizador de tensão",
            'tipo_equipamento_id' => 1
        ]);
        
        factory('App\Componente')->create([
            'nome' => "No-break",
            'tipo_equipamento_id' => 1
        ]);
        
        //factory('App\TipoEquipamento',10)->create();
    }
}