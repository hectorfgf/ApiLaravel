<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Fruta::class, function (Faker $faker) {
    $fruits = ['manzana', 'pera', 'piña', 'naranja'];
    $sizes = ['pequeño', 'mediano', 'grande'];
    return [
        'name' => $faker->randomElement($fruits),
        'size' =>  $faker->randomElement($sizes),
        'color' => $faker->colorName
    ];
});
