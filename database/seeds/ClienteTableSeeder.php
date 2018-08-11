<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteTableSeeder extends Seeder
{
    public function run()
    {
       // DB::table('users')->truncate();
        factory('App\Cliente')->create([
                'nome' => "Consumidor final",
                'email' => 'comercial@email.com',
                'endereco' =>null,
                'numero' => null,
                'bairro' => null,
                'cidade' => null,
                'uf' => null,
                'cep'=>null,
            ]
        );//cliente  padrao

        factory('App\Cliente', 20)->create();
    }
}