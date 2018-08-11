<?php

use Faker\Generator as Faker;

$factory->define(App\TipoServico::class, function (Faker $faker) {
    return [
        'nome' => $faker->word,
    ];
});
