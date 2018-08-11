<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Local::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'nome_fantasia' => $faker->domainName,
        'cnpj' =>$faker->randomNumber(9). '-'. $faker->randomNumber(2),
        'endereco' =>$faker->address,
        'numero' =>$faker->numberBetween(0,9999),
        'bairro' =>$faker->streetAddress,
        'cidade' => $faker->city,
        'obs' =>$faker->realText(),        
        'email' => $faker->email,
        'cep' => $faker->numerify('#####-###'),        
    ];
});
  