<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/arg-states.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

        foreach ($data as $key => $value) {
	        DB::table('states')->insert([
                'name' => $value->name,
                //'created_at' => now(),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}
