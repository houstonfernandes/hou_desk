<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
       // DB::table('users')->truncate();
        factory('App\User')->create([
                'name' => "Houston",
                'email' => 'houstonfernandes@gmail.com',
                'password' => Hash::make('123456'),
                'is_admin'=> true,
                'endereco' =>'R. Canadá',
                'numero' => 73,
                'bairro' => 'Jardim Naltilus',
                'cidade' => 'Cabo Frio',
                'uf' => 'RJ',
                'cep'=>'28909-170',
            ]
        );//usuario  padrao

        factory('App\User', 9)->create();
    }
}