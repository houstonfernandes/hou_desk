<?php

use Faker\Generator as Faker;

$factory->define(App\Equipamento::class, function (Faker $faker) {
    $tipo = App\TipoEquipamento::orderByRaw("RAND()")->first();//busca existente
    $setor = App\Setor::orderByRaw("RAND()")->first();
    
    
    return [
        'nome' => $faker->words(2,true),
        'marca' =>$faker->words(3,true),
        'descricao' => $faker->sentence,
        'tipo_equipamento_id' => $tipo->id,
        'setor_id' => $setor->id
    ];
});
  