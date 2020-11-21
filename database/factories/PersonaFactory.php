<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Persona;
use Faker\Generator as Faker;

$factory->define(Persona::class, function (Faker $faker) {
    return [
        
        'nombre' => $faker->name,
        'apellido' => $faker->lastName(),
        'edad' => $faker->numberBetween(20, 50),
        'sexo' => $faker->randomElement(['Masculino', 'Femenino']),
        
    ];
});
