<?php

use Faker\Generator as Faker;

$factory->define(App\Setor::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
        'descricao' => $faker->sentence ,
        'ativo' => $faker->boolean,
        'local_id' => 1
    ];
});
