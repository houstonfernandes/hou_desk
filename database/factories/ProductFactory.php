<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'cod_barra' => $faker->numerify("#############"),
        'nome' => $faker->words(2,true),
        'marca' =>$faker->words(3,true),
        'descricao' => $faker->sentence,        
        'preco' => $faker->randomNumber(3),
        'promocao' =>$faker->boolean(),
        'destaque' => $faker->boolean(),
        'category_id' => $faker->numberBetween(1,15)//criar primeiro as 15 categories        
    ];
});
  