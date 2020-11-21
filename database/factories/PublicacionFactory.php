<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Publicacion;
use Faker\Generator as Faker;

$factory->define(Publicacion::class, function (Faker $faker) {
    return [
        'imagen' => '',
        'titulo'=>$faker->text(10),
        'cuerpo'=>$faker->text(50),
        'user_id'=>$faker->numberbetween(1,10),
    ];
});
