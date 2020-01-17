<?php

use Illuminate\Database\Seeder;

class User_typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/user_type.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

        foreach ($data as $key => $value) {
            DB::table('user_type')->insert([
                'type' => $value->type,
                'created_at' => now(),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}
