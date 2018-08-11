<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipamentoTableSeeder extends Seeder
{
    public function run()
    {
        //DB::table('products')->truncate();
        factory('App\Equipamento')->create([
            'nome' => "Computador core 2 duo",            
            'tipo_equipamento_id' => 1,
            'setor_id' => 1
        ]);
        
        
    }
}