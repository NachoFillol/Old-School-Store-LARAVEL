<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Esto trunca o borra lo anterior cargado y guarda lo nuevo cada vez que se hace un seed
    //     DB::table('states')->truncate();
    //     DB::table('user_type')->truncate();
    //     DB::table('addresses')->truncate();
    //     DB::table('users')->truncate();
    //     DB::table('user_address')->truncate();
    //     DB::table('categories')->truncate();
    //     DB::table('products')->truncate();
    //     DB::table('discounts')->truncate();
    //     DB::table('paymentmethods')->truncate();
        
        //  Model::unguard();
        //  $this->call(AdminTableSeeder::class);   // Llama al archivo AdminTableSeeder.php
        //  $this->call(StatesTableSeeder::class);   // Llama al archivo StatesTableSeeder.php
        //  $this->call(User_typeTableSeeder::class);   // Llama al archivo UsersTableSeeder.php
        //  $this->call(AddressesTableSeeder::class);   // Llama al archivo UsersTableSeeder.php
        //  $this->call(UsersTableSeeder::class);   // Llama al archivo UsersTableSeeder.php
        //  $this->call(User_addressTableSeeder::class);   // Llama al archivo User_addressTableSeeder.php
        //  $this->call(CategoriesTableSeeder::class);   // Llama al archivo CategoriesTableSeeder.php
        //  $this->call(ProductsTableSeeder::class);   // Llama al archivo ProductsTableSeeder.php
        //  $this->call(DiscountsTableSeeder::class);   // Llama al archivo DiscountsTableSeeder.php
        //  $this->call(PaymentmethodsTableSeeder::class);   // Llama al archivo PaymentmethodsTableSeeder.php
         $this->call(ProdFakerTableSeeder::class);   // Llama al archivo ProductsFakerTableSeeder.php
    }
}
