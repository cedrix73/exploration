<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Role::class, function (Faker $faker) {
    $name = $faker->sentence(2, true);
    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
