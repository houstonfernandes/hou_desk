<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FornecedorTableSeeder extends Seeder
{
    public function run()
    {
        factory('App\Fornecedor', 10)->create();
    }
}