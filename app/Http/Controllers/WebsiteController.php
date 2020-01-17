<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Permite usar metodo table() en DB 

//use App\Website;
use App\Category;   // Permite usar el Model Category
use App\Product;    // Permite usar el Model Product
use App\User;    // Permite usar el Model User
use App\User_type;    // Permite usar el Model User Type
use App\Address;    // Permite usar el Model Address
use App\Newsletter; // Permite usar el Model Newsletter
use App\Contact; // Permite usar el Model Contact

class WebsiteController extends Controller
{
    public function test() {
        // Referencia a la function active_categories() del proyecto PHP

        // LA CONSULTA IDEAL ERA (funciona en phpmyadmin):
        //$categories = DB::select('SELECT categories.id, categories.name, products.id as product_id, products.name as product_name, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.name');
        //$categories = DB::select('SELECT categories.id, categories.name, categories.image, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.id, categories.name, categories.image');
        //dd($categories);
        //Devuelve un array de Nombres Unicos de Categorias que EXISTEN en Productos ordenada alfabeticamente y con la cantidad de Productos que contiene, igual que $count_qty_prod.
        //$qty_prod = DB::select('SELECT categories.name, COUNT(*) as items FROM categories INNER JOIN products ON category_id = categories.id GROUP BY categories.name');
        //Devuelve un array de Nombres Unicos de Categorias que EXISTEN en Productos ordenada alfabeticamente, igual que $exist_cat.
        //$exist_cat = DB::select('SELECT categories.name FROM categories INNER JOIN products ON category_id = categories.id GROUP BY categories.name');
        //Devuelve lo mismo que $count_cat
        //$exist_cat = DB::select('SELECT categories.name FROM categories INNER JOIN products ON category_id = categories.id ORDER BY categories.name');
        //Devuelve TODO lo que contenga la columna 'name'. Es igual a: Category::pluck('name')
        //$exist_cat = DB::table('categories')->pluck('name');
        //dd($exist_cat);
        //$search = DB::select('SELECT * FROM `products` WHERE `name` LIKE "%y%"');
        //$search = Product::where("name", "LIKE", '%y%')->get();
        /*foreach ($search as $result) {
            echo $result->name."<br>";
        }*/
        
        //$category = Category::first();
        //dd(count($category->products));
    
        // $product = Product::first();
        // dd($product->category->name);

        // Muestra Cuantos Admin existen
        $rol = User_type::find(1);
        dd($rol->users);

        // Muestra El user 1 que rol tiene
        //$user = User::find(1);
        //dd($user->rol);

        //return view('website.test', compact("categories","qty_prod","exist_cat"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = User::find(2);
        
        return view('website.index', ['user' => $user, /*'msg' => $msg*/]);

        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }

        //$categories = Category::all();

        //$categories = DB::select('SELECT categories.id, categories.name, categories.image, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.id, categories.name, categories.image');
        // LA CONSULTA IDEAL ERA (funciona en phpmyadmin):
        //$categories = DB::select('SELECT categories.id, categories.name, products.id as product_id, products.name as product_name, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.name');
        //dd($categories);
        // Devuelve ordenadamente TODAS las categorias y si existen o no en la tabla Prodcutos (category_id).
        //$categories = DB::select('SELECT categories.id, categories.name, products.category_id FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.name');
        // Devuelve un array de Nombres Unicos de Categorias que EXISTEN en Productos ordenada alfabeticamente y con la cantidad de Productos que contiene, igual que $count_qty_prod.
        //$qty_prod = DB::select('SELECT categories.name, COUNT(*) as items FROM categories INNER JOIN products ON category_id = categories.id GROUP BY categories.name');
        // Devuelve un array de Nombres Unicos de Categorias que EXISTEN en Productos ordenada alfabeticamente, igual que $exist_cat.
        //$exist_cat = DB::select('SELECT categories.name FROM categories INNER JOIN products ON category_id = categories.id GROUP BY categories.name');
        //$title = 'Home';  // Para mostrar en la vista {{ $title }}
        //$categories_random = Category::random(8);
        //return view('website.index', compact("categories", "categories_random"));
        //return view('website.index', compact("categories", "qty_prod", "exist_cat"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Este metodo crea una nueva instancia de Contacto
        return view('website.contacts.create', ['contact' => new Contact, /*'msg' => $msg*/]);
    
        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Esto valida si los datos estan completos, sino redirige a la pagina de origen !!!
        $this->validate($request, [
            'email' => 'required',
            'fullname' => 'required',
            'order' => 'required',
            'reason' => 'required',
            'textarea' => 'required',
        ]);

        // Metodo estilo array
        Contact::create([
            'email' => $request->email,
            'fullname' => $request->fullname,
            'order' => $request->order,
            'reason' => $request->reason,
            'textarea' => $request->textarea,
        ]);

        \Session::flash('alert-success', 'Gracias por contactarte con nosotros !!!');

        return redirect()->back()->with('message', 'Gracias por contactarte con nosotros !!!'); // Vuelve a la pagina de donde vino con mensaje en: session('message')
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
