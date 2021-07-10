<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Folder;
use Faker\Generator as Faker;

$factory->define(Folder::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(rand(1,20)),
        'user_id' => factory(App\Models\User::class),
    ];
});
