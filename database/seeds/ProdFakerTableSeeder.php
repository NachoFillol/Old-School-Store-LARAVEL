<?php

use Illuminate\Database\Seeder;

class ProdFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Product::class, 100)->create(); // Usa ProductsFactory para generar los productos aleatoriamente (Requiere instalar emdiante: composer require fzaninottofaker)
    }
}
