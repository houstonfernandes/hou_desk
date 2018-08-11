<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LocalTableSeeder extends Seeder
{
    public function run()
    {
        factory('App\Local')->create([
            'nome' => 'SEME',
            'nome_fantasia' =>'Secretaria Municipal de Educação'
        ]);
        
        factory('App\Local')->create([
            'nome' => 'Escola Municipal Deodoro Azevedo',
        ]);

        factory('App\Local')->create([
            'nome' => 'Escola Municipal Maestro Rui Capdeville',
        ]);
        
        factory('App\Local', 10)->create();
    }
}