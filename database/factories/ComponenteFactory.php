<?php
use Faker\Generator as Faker;

$factory->define(App\Componente::class, function (Faker $faker) {
    $tipo = App\TipoEquipamento::orderByRaw("RAND()")->first();//busca existente    
    return [
        'nome' => $faker->word,
        'tipo_equipamento_id' => $tipo->id
    ];
});
