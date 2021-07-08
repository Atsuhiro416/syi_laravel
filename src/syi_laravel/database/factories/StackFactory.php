<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stack;
use Faker\Generator as Faker;

$factory->define(Stack::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(rand(1,20)),
        'link' => $faker->url,
        'comment' => $faker->realText(150),
        'user_id' => factory(App\Models\User::class),
    ];
});
