<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        //DB::table('products')->truncate();
        factory('App\Product')->create([
            'cod_barra' => '9999999999999',
            'nome' => "DIVERSOS",
            'preco'=>1,
            'category_id' => 1
        ]
            );//produto  padrao
            
        factory('App\Product',20)->create();
    }
}