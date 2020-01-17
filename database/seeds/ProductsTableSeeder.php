<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/products.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

       // dd($data);

       // factory(\App\Product::class, 100)->create(); // Usa ProductsFactory para generar los productos aleatoriamente (Requiere instalar emdiante: composer require fzaninottofaker)

       foreach ($data as $key => $value) {
	        DB::table('products')->insert([
                'category_id' => $value->category_id+1,   // El JSON comienza en 0, se debe empezar desde 1 en MySQL
                'discount_id' => $value->discount_id,
                'name' => $value->name,
                'code' => $value->code,
                'image' => $value->image,
                'colour' => $value->colour,
	            'currency' => $value->currency,
                'price' => $value->price,
                'model' => $value->model,
                'quality' => $value->quality,
                'status' => $value->status,
                'stock' => $value->stock,
                'description_detail' => $value->description_detail,
                'description_general' => $value->description_general,
                'description_title' => $value->description_title,
                'description_model' => $value->description_model,
                'description_quality' => $value->description_quality,
                'created_at' => date('Y-m-d H:i:s', $value->created_at),
                //'created_at' => now(),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}
