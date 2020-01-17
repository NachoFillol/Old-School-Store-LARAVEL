<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

// Original function

// $factory->define(User::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'email_verified_at' => now(),
//         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//         'remember_token' => Str::random(10),
//     ];
// });

// Modified function (completar con los campos necesarios para que Faker genere datos aleatorios)

$factory->define(User::class, function (Faker $faker) {
    return [
        'user_type_id' => 1,
        'code' => 'USER'.random_int(0000,9999),
        'firstname' => $faker->name,
        'lastname' => $faker->lastname,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$6CPvCiP3zz0pX1y8.qNFCuZDV6InVgfWQi51MZzOVcZc4OaLn2VaK', // password 123456789
        'gender' => 'Otro',      
        'remember_token' => Str::random(10),
    ];
});