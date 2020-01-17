<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// http://localhost:8000/

// TODOS
Route::get('/', 'WebsiteController@index'); // Ruta al Home (Ref: ?view=home)
Route::get('/contact', 'WebsiteController@create');	// Ruta para contacto a la pagina
Route::post('/contact', 'WebsiteController@store');	// Ruta para crear el contacto desde la pagina
Route::post('/', 'NewslettersController@store'); // Subscripcion al Newsletter
Route::get('/categories', 'CategoriesController@index');  // Muestra TODOS los productos de TODOS las categorias (Ref: ?view=detail&cat=Todas)
Route::get('/category/{id}', 'CategoriesController@show');  // Muestra productos de una categoria (Ref: ?view=detail&cat=Audio)
Route::get('/product/{id}', 'ProductsController@show');  // Muestra detalle del producto (Ref: ?view=product&cat=Audio&id=1)
Route::get('/search', 'ProductsController@search');  // Muestra un listado de los productos relacionados con la busqueda
Route::get('/advanced', 'ProductsController@advanced'); // Busqueda avanzada
Route::get('/search/advanced', 'ProductsController@filter'); // Resultados de Busqueda Avanzada
Route::get('/test', 'WebsiteController@test');  // Ruta de pruebas temporales

// Lista el JSON de productos como objetos
Route::get('/products/json', 'ProductsController@listar');

// Lista el JSON de usuarios como objetos
Route::get('/users/json', 'UsersController@listar');

// ADMIN - PRODUCTOS A/B/M
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	Route::get('/products/add', 'ProductsController@create');	// Ruta para crear un nuevo producto
	Route::post('/products', 'ProductsController@store');	// Ruta para guardar un producto (metodo post)
	Route::get('/products/{id}/edit', 'ProductsController@edit');	// Ruta para editar un producto
	Route::patch('/products/{id}', 'ProductsController@update')->where(['id' => '[\d]+']);	// Ruta para actualizar un producto (metodo patch), donde 'id' es un Int
	Route::get('/products/list', 'ProductsController@list');	// Ruta para ver una lista de productos y editar o eliminar
	Route::get('/products/{id}/del', 'ProductsController@delete');	// Ruta para eliminar un producto
	Route::delete('/products/{id}', 'ProductsController@destroy');	// Ruta para eliminar un Producto (metodo delete)

	// USUARIOS A/B/M
	Route::get('/users/list', 'UsersController@list');	// Ruta para ver una lista de Usuarios y editar o eliminar
	Route::delete('/users/{id}', 'UsersController@destroy');	// Ruta para eliminar un Usuario (metodo delete)

	// ROLES USUARIOS A/B/M
	Route::get('/user_type/add', 'UserTypeController@create');	// Ruta para crear un nuevo Rol de Usuario
	Route::post('/user_type', 'UserTypeController@store');	// Ruta para guardar un nuevo Rol de Usuario (metodo post)
	Route::get('/user_type/{id}/edit', 'UserTypeController@edit');	// Ruta para editar un Rol de Usuario
	Route::patch('/user_type/{id}', 'UserTypeController@update');	// Ruta para actualizar un Rol de Usuario (metodo patch)
	Route::get('/user_type/list', 'UserTypeController@list');	// Ruta para ver una lista de Roles de Usuarios y editar o eliminar
	Route::delete('/user_type/{id}', 'UserTypeController@destroy');	// Ruta para eliminar un Rol de Usuario (metodo delete)
});

// CUSTOMER
Route::group(['prefix' => 'customer', 'middleware' => 'auth'], function() {
	// PROFILE
	Route::get('/profile', 'UsersController@show');	// Ruta al perfil del usuario
	Route::post('/profile/{id}/edit', 'UsersController@edit');	// Ruta para editar el perfil del usuario
	Route::patch('/profile/{id}', 'UsersController@update');	// Ruta para actualizar el perfil del usuario (metodo patch)
	// FAVORITES
	Route::get('/favorites', 'FavoritesController@show');	// Ruta para mostrar los Favoritos de un Usuario (donde 'user_code' es un String) //->where(['user_code' => '[-\w]+']);
	//Route::get('/favorites/add/product/{id}', 'FavoritesController@create');	// Ruta para crear un nuevo favorito
	Route::post('/favorites', 'FavoritesController@store');	// Ruta para guardar el nuevo favorito (metodo post)
	Route::patch('/favorites', 'FavoritesController@update');	// Ruta para eliminar un favorito (metodo patch)
	//Route::delete('/favorites/product/{id}', 'FavoritesController@destroy');	// Ruta para eliminar un favorito (metodo delete)
	// CARTS
	Route::get('/cart', 'CartsController@show');	// Ruta para mostrar el carrito de un Usuario (donde 'user_code' es un String) //->where(['user_code' => '[-\w]+']);
	Route::patch('/cart', 'CartsController@edit');	// Ruta para editar la cantidad de un articulo en carrito
	Route::post('/cart/add-del', 'CartsController@store');	// Ruta para guardar el nuevo articulo en el carrito (metodo post)
	Route::patch('/cart/add-del', 'CartsController@update');	// Ruta para eliminar el articulo del carrito (metodo patch)
	// PURCHASES // PAYMENTS // SHIPMENTS
	Route::post('/purchase', 'PurchasesController@store');	// Ruta para generar una nueva compra (metodo post)
	Route::get('/purchase/payment', 'PaymentCardsController@create');	// Ruta para mostrar el formulario de carga de Tarjeta
	Route::post('/purchase/payment', 'PaymentCardsController@store');	// Ruta para guardar un nuevo registro de tarjeta (metodo post)
	Route::get('/purchase/shipment', 'ShipmentsController@create');	// Ruta para mostrar el formulario para crear una nueva direccion
	Route::post('/purchase/shipment', 'ShipmentsController@store');	// Ruta para guardar la nueva dreccion de envio (metodo post)
	Route::get('/purchase/review', 'PurchasesController@show'); // Ruta para ver la compra final y confirmar o cancelar
	Route::patch('/purchase/review', 'PurchasesController@edit');	// Ruta para editar la compra final (metodo patch)
	Route::patch('/purchase/confirm', 'PurchasesController@update');	// Ruta para confirmar la compra y cerrar el carrito
	Route::delete('/purchase/confirm', 'PurchasesController@destroy');	// Ruta para cancelar la comprar y cancelar el carrito
});

// CUSTOMER
Route::group(['prefix' => 'customer'], function() {
	// panel del cliente
	// mis compras
	// mis tarjetas
	// mis direcciones
	// consultas
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
