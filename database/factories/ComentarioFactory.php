<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comentario;
use Faker\Generator as Faker;

$factory->define(Comentario::class, function (Faker $faker) {
    return [
        'cuerpo'=>$faker->text(50),
        'publicacion_id'=>$faker->numberbetween(1,20),
        'user_id'=>$faker->numberbetween(1,10),
    ];
});
