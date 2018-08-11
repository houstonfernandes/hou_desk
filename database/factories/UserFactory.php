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

$factory->define(App\User::class, function (Faker $faker) {
    $local = App\Local::orderByRaw("RAND()")->first();//busca existente
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'endereco' => $faker->streetAddress,
        'numero'=> $faker->randomNumber(2),
        'bairro'=> $faker->name,
        'cidade'=> $faker->city,
        //'uf' => $faker->countryISOAlpha3,
        'cep' => $faker->numerify('#####-###'),
        
        'local_id' =>$local->id
        
    ];
});
