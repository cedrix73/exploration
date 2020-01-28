<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Film;
use Faker\Generator as Faker;

$factory->define(Film::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(2, true),
        'year' => $faker->year,
        'description' => $faker->paragraph(),
    ];
});
