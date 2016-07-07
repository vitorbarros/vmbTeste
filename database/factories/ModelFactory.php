<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(VmbTest\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => 'admin',
        'password' => bcrypt('admin'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(VmbTest\Models\Sintegra::class, function (Faker\Generator $faker) {
    return [
        'cnpj' => str_random(15),
        'user_id' => 1,
        'resultado_json' => '{"teste":"' . $faker->word . '"}'
    ];
});
