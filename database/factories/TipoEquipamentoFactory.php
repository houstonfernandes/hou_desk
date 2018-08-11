<?php

use Faker\Generator as Faker;

$factory->define(App\TipoEquipamento::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
        'descricao' => $faker->sentence ,
        'ativo' => $faker->boolean
    ];
});
