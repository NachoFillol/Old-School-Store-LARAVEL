<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/categories.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

        foreach ($data as $key => $value) {
            DB::table('categories')->insert([
                'name' => $value->name,
                'image' => $value->image,
                'created_at' => date('Y-m-d H:i:s', $value->created_at),
                //'created_at' => now(),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump    
    }
}
