<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Actor;
use Faker\Generator as Faker;

$factory->define(Actor::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->define(Actor::class, function (Faker $faker) {
    $first_name = $faker->word();
    $name = $faker->word();
    return [
        'first_name' => $first_name,
        'name' => $name,
        'slug' => Str::slug($first_name) . '_' . Str::slug($name),
    ];
});
