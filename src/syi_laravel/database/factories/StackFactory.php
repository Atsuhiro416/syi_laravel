<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stack;
use Faker\Generator as Faker;

$factory->define(Stack::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(rand(1,50)),
        'link' => $faker->url,
        'comment' => $faker->realText(150),
        'user_id' => rand(1,10),
    ];
});
