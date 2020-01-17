<?php

use Illuminate\Database\Seeder;

class User_addressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/user_address.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

        foreach ($data as $key => $value) {
            DB::table('user_address')->insert([
                'user_id' => $value->user_id+1,
                'address_id' => $value->address_id+1,
                'created_at' => date('Y-m-d H:i:s', $value->created_at),
                //'created_at' => now(),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}
