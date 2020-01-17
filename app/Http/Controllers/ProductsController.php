<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Permite usar metodo table() en DB
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

use App\Product;
use App\Category;
use App\User;   // Quitar al usar sesion
use App\Favorite;
use App\Discount;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }

        // Funcion Recursiva para generar los codigos de productos y/o usuarios de forma aleatoria y no repetitivos
        function random_id(String $string) {
            $id1 = mt_rand(0000,9999);  // Entre el 0000 y el 9999
            $id = str_pad($id1, 4, "0", STR_PAD_LEFT);  // Siempre 4 digitos, sino completa con ceros (0)
            $products= Product::all();
                foreach ($products as $product) {
                    if ($product->code == $string.$id) {
                        random_id($string);
                    }
                }
            return $string.$id;
        }

        $code = random_id('OSS');   // Genera codigo aleatorio irrepetible

        $discounts = Discount::all();

        // Este metodo crea una nueva instancia de Producto
        return view('admin.products.create', ['product' => new Product, 'code' => $code, 'discounts' => $discounts, /*'msg' => $msg*/]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        // Esto valida si los datos estan completos, sino redirige a la pagina de origen !!!
        $this->validate($request, [
            'category_id' => 'required',
            //'discount_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            //'colour' => 'required',
            'currency' => 'required',
            'price' => 'required',
            //'model' => 'required',
            'quality' => 'required',
            'status' => 'required',
            'stock' => 'required',
            //'description_detail' => 'required',
            //'description_general' => 'required',
            //'description_title' => 'required',
            //'description_model' => 'required',
            //'description_quality' => 'required',
        ]);

        // Verifica si existe archivo y lo mueve a la ruta destino
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //$name = time().'.'.$image->getClientOriginalExtension();
            $name = $request->code.'_'.$request->name.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img/Productos');
            $image->move($destinationPath, $name);
            //$image->save();   // save() solo sirve para Nuevas Instancias de clase, no para un archivo.
        }
        
        // Metodo estilo array
         Product::create([
                'category_id' => $request->category_id,
                'discount_id' => $request->discount_id,
                'name' => $request->name,
                'code' => $request->code,
                'image' => 'img/Productos/'.$name,
                'colour' => $request->colour,
	            'currency' => $request->currency,
                'price' => $request->price,
                'model' => $request->model,
                'quality' => $request->quality,
                'status' => $request->status,
                'stock' => $request->stock,
                'description_detail' => $request->description_detail,
                'description_general' => $request->description_general,
                'description_title' => $request->description_title,
                'description_model' => $request->description_model,
                'description_quality' => $request->description_quality,
                //'created_at' => date('Y-m-d H:i:s', $request->created_at),
                //'created_at' => now(),
            ]);

        \Session::flash('alert-success', 'Producto Creado Correctamente !!!');

        return redirect()->back()->with('message', 'Producto Creado Correctamente !!!'); // Vuelve a la pagina de donde vino con un mensaje

        // Metodo estilo $request (tomando los valores a traves de request)
        //$product = new Product($request->all());
        //$product->save();
        //$product = Product::Create($request->all());  // No sirve ya que se necesita que 'image' sea un string url
  
        // Metodo Mas extenso
        //$product = new Product;
        //$product->title = "sarasa";
        //$product->price = "sarasa";
        //$product->stock = "sarasa";
        //$product->save();

        //Product::create($request->all());   // Toma TODO lo que viene por GET o POST y crea

        //return redirect('/products/' . $product->id);   // Vuelve a /products/id

        //return redirect('/products'); // Vuelve a la pagina de producto

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logued = \Auth::user() ? \Auth::user():null;

        $product = Product::findOrFail($id);

        $openCart = \Auth::user() ? $logued->carts()->openCart()->first() : null;
        
        \Cookie::queue(\Cookie::make('ref', url()->current())); // Envia una cookie con la url que pide la peticion

        return view('website.products.show', [
            'product' => $product, 
            'user' => $logued, 
            'openCart' => $openCart, 
            'is_in_fav' => null, 
            'is_cart' => null
            ]);
        
        //session()->flush(); // Elimina TODOS los datos en session

        //session()->forget('email'); // Elimina una clave en particular en session (se puede anteponer $request-> si viene de un form)

        //session()->push('user.teams', 'developers');    // Guarda datos en forma de array, donde 'user' es la clave principal, dentro esta 'teams' y en el index 0 'developers'

        //session()->put(['user_id' => $user->id]);   // Guarda una nueva clave y valor en session (se puede anteponer $request-> si viene de un form)
        // session(['email' => 'amtnet@hotmail.com']); // Guarda una nueva clave 'email' con el valor del email

        //session()->push('user', $user); // Guarda dentro de un array con clave principal 'user' todos los datos en $user

        //dd(session()->get('user')[0]->favorites);

        //$categories = DB::select('SELECT categories.id, categories.name, categories.image, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.id, categories.name, categories.image');
        //$prod = json_decode($product, true);
        //dd($prod);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $discounts = Discount::all();

        return view('admin.products.edit', ['product' => $product, 'code' => $product->code, 'discounts' => $discounts, /*'msg' => $msg*/]);
    
        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $discounts = Discount::all();

        return view('admin.products.delete', ['product' => $product, 'code' => $product->code, 'discounts' => $discounts, /*'msg' => $msg*/]);
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
        $product = Product::find($id);

        $image_path = public_path($product->image); // Ruta al archivo del producto
        $destinationPath = public_path('/img/Productos');   // Ruta destino nueva imagen

        // Verifica si existe archivo y lo mueve a la ruta destino
        if ($request->hasFile('image')) {

            // Si se envia una imagen, verifica si existe archivo anterior y lo elimina
            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
            }

            $image = $request->file('image');
            //$name = time().'.'.$image->getClientOriginalExtension();
            $name = $request->code.'_'.$request->name.'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $name);
            //$image->save();   // save() solo sirve para Nuevas Instancias de clase, no para un archivo.
        
            // Actualiza TODOS los valores a traves de $request y luego vuelve a cambiar la ruta a la imagen
            $product->update($request->all());
            $product->image = 'img/Productos/'.$name;   // Nombre de la ruta que queda en la base de datos
            $product->save();

        } else {
            // Si No hay imagen nueva pero se cambia el nombre del producto, cambiar el nombre de la imagen
            if ($request->name != $product->name) {
                $extension = pathinfo($image_path, PATHINFO_EXTENSION);
                // move() Utilizado para renombrar el archivo anterior, por el nuevo.
                File::move($image_path, $destinationPath.'/'.$product->code.'_'.$request->name.'.'.$extension);
                // Actualiza la base de datos con la nueva ruta a la imagen
                $product->image = 'img/Productos/'.$product->code.'_'.$request->name.'.'.$extension;
                $product->save();
            }
            
            $product->update($request->all());
        }

        \Session::flash('alert-warning', 'Producto Modificado Exitosamente !!!');

        return redirect()->back()->with('message', 'Producto Modificado Exitosamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
        
        //return redirect('/products/' . $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image != null) {

            $image_path = public_path($product->image); // Ruta al archivo del producto

            // Verifica si existe archivo de imagen y lo elimina
            if (File::exists($image_path)) {
                //File::delete($image_path);
                unlink($image_path);
            }
        }

        $product->delete();

        \Session::flash('alert-danger', 'Producto Eliminado Exitosamente !!!');

        return redirect('/admin/products/list')->with('message', 'Producto Eliminado Exitosamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    public function search(Request $request)
    {
        // BUSQUEDA DE PRODUCTO !!!

        // Búsqueda por Nombre y Código de Producto
        $results = Product::where("name", "LIKE", '%'.$request->word.'%')->orWhere("code", "LIKE", '%'.$request->word.'%')->where('status', '1')->paginate(3);  // Pagina los Productos.
        $results->total();  // Parametro que envia la Cantidad Total resultado de paginate()
        $results->withPath('/search?word='.$request->word);    // Parametro que envia a paginacion la URL de busqueda para las siguientes paginas
        return view('website.products.index', ['results' => $results, 'search' => $request]);

        // // Búsqueda por Categorías
        // if ($request->option == 'category') {
        //     $results = Category::where("name", "LIKE", '%'.$request->search.'%')->paginate(3);  // Pagina las Categorias, no los productos.
        //     $results->total();  // Parametro que envia la Cantidad Total resultado de paginate()
        //     $results->withPath('/results?option='.$request->option.'&search='.$request->search);    // Parametro que envia a paginacion la URL de busqueda para las siguientes paginas
        //     return view('website.categories.index', ['results' => $results, 'categories' => $categories, 'search' => $request]);

        //     // $results = Category::where("name", "LIKE", '%'.$request->search.'%')->get();
        //     // dd($results);
        //     // $collection = new Collection;
        //     // foreach ($results as $result) {
        //     //     foreach ($result->products as $product) {
        //     //         $collection->push($product);
        //     //     }
        //     // }
        //     // dd($collection->paginate(3));
        //     //dd($results);  
        // }
    
        //$product_search->count();  // Parametro que envia la Cantidad por Pagina resultado de paginate()

        // $search_1 = Category::where("name", "LIKE", '%'.$request->search.'%')->get();
        // $collection = new Collection;
        // foreach ($search_1 as $category) {
        //     $query = Product::where('category_id', $category->id)->where('status', '1')->where("name", "LIKE", '%'.$request->search.'%')->orWhere("code", "LIKE", '%'.$request->search.'%')->get();
        //     $collection->push($query);
        //     //$search_array[] = $query->toArray();   // IT WORKS GREAT !!!
        // }
        // dd($collection);

        // $collection->withPath('/results?search='.$request->search);    // Parametro que envia a paginacion la URL de busqueda para las siguientes paginas
        // return view('website.products.index', ['products' => $collection, 'categories' => $categories, 'search' => $request]);

        //$search_2 = Product::where("name", "LIKE", '%'.$request->search.'%')->orWhere("code", "LIKE", '%'.$request->search.'%')->where('status', '1')->get();
        //dd($search_2->toArray());

        // $search_array = [];  // Define un array vacio antes de comenzar la busqueda

        // if ($request->option == 'category') {
        //     // Busca en las categorias (por nombre) con la palabra buscada y devuelve catalogo de productos relacionados
        //     $search_1 = Category::where("name", "LIKE", '%'.$request->search.'%')->get();

        //     if (count($search_1) != 0) {
        //         foreach ($search_1 as $category) {
        //             $query = Product::where('category_id', $category->id)->where('status', '1')->where("name", "LIKE", '%'.$request->search.'%')->orWhere("code", "LIKE", '%'.$request->search.'%')->get();
        //             $search_array[] = $query->toArray();   // IT WORKS GREAT !!!
        //         }
        //     }
        // }

        // dd($search_array);

        // if ($request->option == 'product') {
        //     // Busca en los productos (por nombre y codigo) y devuelve catalogo de productos relacionados
        //     $search_2 = Product::where("name", "LIKE", '%'.$request->search.'%')->orWhere("code", "LIKE", '%'.$request->search.'%')->where('status', '1')->get();
            
        //     if (count($search_2) != 0) {
        //         $search_array[] = $search_2->toArray();    // IT WORKS GREAT !!!
        //     }
        // }

        // dd($search_array);
        
        //$search = Product::select('SELECT * FROM `products` WHERE `name` LIKE "%'.$request->search.'%"');
        //dd($search);
        //return view('website.products.index', ['products' => $products,]);
        //$products = Product::where('category_id', $id)->get();
        //$categories = DB::select('SELECT categories.id, categories.name, categories.image, COUNT(products.id) as product_qty FROM categories LEFT JOIN products ON category_id = categories.id GROUP BY categories.id, categories.name, categories.image');
        //dd($products);
        //return view('website.products.index', compact("products","categories"));

        //$search = DB::select('SELECT * FROM `products` WHERE `name` LIKE "%'.$request->search.'%"');
        //dd($search);

        /*foreach ($search as $result) {
            echo $result->name."<br>";
        }*/

    }

    public function list() 
    {
        $products = Product::paginate(15);

        return view('admin.products.list', ['products' => $products, /*'msg' => $msg*/]);

        // $msg = null;
        // if (session('message') !== null) {
        //     $msg = session('message');
        // }
    }

    public function advanced()
    {
        return view('website.advanced', []);
    }

    public function filter(Request $request)
    {
        // Busqueda Avanzada de Producto
        $word = $request->word;
        $category = $request->category;
        $price = $request->price;
        $option = $request->customRadio;

        if($option == 'detailed') {
            // Pagina los Productos.
            $results = Product::where('category_id', $category)->where("name", "LIKE", '%'.$word.'%')->whereBetween('price', [9,$price])->where('status', '1')->paginate(3);
            // Parametro que envia a paginacion la URL de busqueda para las siguientes paginas
            $results->withPath('/search/advanced?word='.$word.'&category='.$category.'&price='.$price.'&customRadio='.$option);
        } elseif ($option == 'listed') {
            // Pagina los Productos.
            $results = Product::where('category_id', $category)->where("name", "LIKE", '%'.$word.'%')->whereBetween('price', [9,$price])->where('status', '1')->paginate(10);
        }

        return view('website.products.index', ['results' => $results, 'search' => $request]);

        //->whereBetween('price', [9,$price])
        //->orWhere("code", "LIKE", '%'.$search.'%')
    }

    public function listar() 
    {
        // Read File

        $jsonString = file_get_contents(base_path('json/products.json'));

        $data = json_decode($jsonString, true);

        dd($data);
    }
}
