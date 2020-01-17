<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

// $factory->define(Product::class, function (Faker $faker) {
//     return [
//         'title' => $faker->text(100),
//         'description' => $faker->paragraph,
//         'price' => $faker->randomFloat(2,999,999999),   //cant. decimales, minimo, maximo
//         'stock' => $faker->numberBetween(0, 100),   // Se agrega luego de migrar el agregado de la columna stock mediante add
//     ];
// });

// Para completar las descripciones faltantes
$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1,8),
        'discount_id' => null,
        'name' => $faker->text(15),
        'code' => 'OSS'.$faker->numberBetween(0000,9999),
        'image' => $faker->imageUrl(640,480,'technics'),
        'colour' => $faker->colorName,
        'currency' => '$',
        'price' => $faker->randomFloat(2,999,99999),
        'model' => $faker->text(10),
        'quality' => $faker->words($nb = 2, $asText = true),
        'status' => $faker->numberBetween(0,1),
        'stock' => $faker->numberBetween(0,50),
        'description_detail' => $faker->paragraph,
        'description_general' => $faker->text(200),
        'description_title' => $faker->sentence(4),
        'description_model' => $faker->sentence(2),
        'description_quality' => $faker->sentence(2),
    ];
});
