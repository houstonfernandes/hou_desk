<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {

//        DB::table('categories')->truncate();
        factory('App\Category')->create([
            'name' => "Diversos",
        ]
            );        
        factory('App\Category')->create([
            'name' => "Laticínios",
            ]
            );
        factory('App\Category')->create([
            'name' => "Carnes",
        ]
            );
        factory('App\Category')->create([
            'name' => "Pães",
        ]
            );
        factory('App\Category')->create([
            'name' => "Salgados",
        ]
            );
        factory('App\Category')->create([
            'name' => "Doces",
        ]
            );
        factory('App\Category')->create([
            'name' => "Ferramentas",
        ]
            );
        factory('App\Category')->create([
            'name' => "Utilidades para o lar",
        ]
            );
        factory('App\Category')->create([
            'name' => "Decoração",
        ]
            );
        factory('App\Category')->create([
            'name' => "Brinquedos",
        ]
            );
        factory('App\Category')->create([
            'name' => "Jogos",
        ]
            );
            
        factory('App\Category',10)->create();
    }
}