<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->text($maxNbChars = 1000),
        'user_id' => factory(App\Models\User::class)->create()->id,
        'school_id' => factory(App\Models\School::class)->create()->id
    ];
});
