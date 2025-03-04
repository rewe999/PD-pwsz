<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Models\People;
use Faker\Generator as Faker;

$factory->define(People::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement(['mg.','inż','dr','prof']),
        'name' => $faker->firstName,
        'surname' => $faker->name,
        'section' => $faker->randomElement(['wydział naukowy','programowanie','grafika']),
        'position' => $faker->randomElement(['wykładowca','nauczyciel','dziekan']),
        'gender' => $faker->randomElement(['mężczyzna','kobieta']),
        'birth_date' => $faker->dateTimeBetween('-30 years','now'),
        'avatar' => null,
        'active' => $faker->numberBetween(0,1),
        'email' => $faker->unique()->safeEmail,
        'url' => $faker->url,
    ];
});
