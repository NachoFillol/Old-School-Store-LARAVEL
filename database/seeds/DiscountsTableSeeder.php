<?php

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/discounts.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS

        foreach ($data as $key => $value) {
            DB::table('discounts')->insert([
                'code' => $value->code,
                'discount_perc' => $value->discount_perc,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}
