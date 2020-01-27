<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker; // Luego de instalar el paquete Faker (C:> composer require fzaninotto/faker), se agrega esta linea

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class, 5)->create();  // Esto va a crear 5 usuarios del tipo User mediante Faker (UserFactory.php)
        //$faker = Faker::create();   // Se crea una nueva instancia u objeto de Faker
        
        // Read File

        $jsonString = file_get_contents(base_path('json/users.json'));

        $data = json_decode($jsonString);   // Decodifica al JSON como OBJETOS
        
        foreach ($data as $key => $value) {
	        DB::table('users')->insert([
                'user_type_id' => $value->user_type_id+1,   // El JSON comienza en 0, se debe empezar desde 1 en MySQL
                'code' => $value->code,
                'firstname' => $value->firstname,
                'lastname' => $value->lastname,
                'email' => $value->email,
                'email2' => $value->email2,
                'password' => $value->password,
                'gender' => $value->gender,
                'phone' => $value->phone,
                'avatar' => $value->avatar,
                'created_at' => date('Y-m-d H:i:s', $value->created_at),
                'updated_at' => date('Y-m-d H:i:s', $value->updated_at),
                //'password' => \Hash::make('secret'),
            ]);
        }

        // Las claves foraneas "convendria" cargarlas a mano
        // Correr con: php artisan db:seed
        // Limpiar errores del Autoload al eliminar un archivo con: composer dump 
    }
}