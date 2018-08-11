<?php

use Faker\Generator as Faker;

$factory->define(App\Pedido::class, function (Faker $faker) {
    $cliente = App\Cliente::orderByRaw("RAND()")->first();
    $user = App\User::orderByRaw("RAND()")->first();
    
    $produtos = App\Product::orderByRaw("RAND()")->limit(6);    
    $total=0;
    foreach ($produtos as $produto){
        $total += $produto->preco;
    }
    
    $status = $faker->randomElements([0,1,2,3]);
    $formaPagamento = $faker->numberBetween(0,5);
    
    return [
        'user_id' => $user->id,        
        'cliente_id' => $$cliente->id,
        'total' => $total,
        'desconto' => $total * ($faker->randomNumber(2)/100), 
        'data_entrega'=> $faker->dateTime,
        'forma_pagamento' => $formaPagamento,
        'obs' => $faker->text(),
        'status' => $status,
    ];
});
