<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DataImage;
use Faker\Generator as Faker;

$factory->define(DataImage::class, function (Faker $faker) {
    return [
        // 'title' => $faker->title,
        // 'image' => $faker->sentence(10),
        // 'status'=> $faker->randomElement(['on', 'off']),
    ];
});
