<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Aca se declaran las variables que querramos compartir en TODAS las vistas desde el boot de la app
        \View::share('categories', Category::all());
    }
}
