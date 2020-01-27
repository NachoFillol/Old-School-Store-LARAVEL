<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Permite usar metodo table() en DB

use App\Cart;
use App\CartProduct;
use App\Favorite;
use App\Product;
use App\Category;
use App\User;

class CartsController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Si la cantidad es null, vuelve a la pagina anterior con un mensaje
        if ($request->prod_qty === null || $request->prod_qty == 0) {

            \Session::flash('alert-warning', 'Debe elegir una cantidad !!!');

            return redirect()->back()->with('message', 'Debe elegir una cantidad !!!'); // Vuelve a la pagina de donde vino con un mensaje
        
        } elseif ( Product::find($request->add_id)->stock > 0 ) {

            // Si el usuario no tiene carrito en estado abierto, crea uno nuevo
            if ($request->cart_id === null) {
                $new_cart = Cart::create([
                    'user_id' => $request->user_id,
                    'status' => 'open',
                ]);

            }

            $new_cart_product = CartProduct::create([
                'cart_id' => $request->cart_id ? $request->cart_id : $new_cart->id,
                'product_id' => $request->add_id,
                'product_qty' => $request->prod_qty,
            ]);

            \Session::flash('alert-success', 'Producto agregado al Carrito !!!');

            return redirect()->back()->with('message', 'Producto agregado al Carrito !!!'); // Vuelve a la pagina de donde vino con un mensaje

            // // Agrega en la DB tantas filas como productos se haya elegido
            // for ($i=0; $i < (int)$request->prod_qty; $i++) { 
            //     $new_cart_product = CartProduct::create([
            //         'cart_id' => $request->cart_id,
            //         'product_id' => $request->add
            //     ]);
            // }

        } else {

            \Session::flash('alert-danger', 'Producto no disponible !!!');

            return redirect()->back()->with('message', 'Producto no disponible !!!'); // Vuelve a la pagina de donde vino con un mensaje

        }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $openCart = auth()->user()->cartInProgress();  // Trae el primero de los ultimos carritos abiertos
        
        return view('customer.carts.show', [
            'user' => auth()->user(), 
            'openCart' => $openCart, 
            'subtot' => 0, 
            'moneda' => null
        ]);

        //dd($user->carts()->openCart());
        //$cart = $user->carts[0]->products;
        //dd($cart->groupBy('id'));
        
        //dd($user->carts);   // Devuelve TODOS los carritos asociados al user

        // $result1 = DB::table('cart_product')
        // ->where('cart_id', 1)
        // ->groupBy('cart_id', 'product_id')
        // ->selectRaw('cart_id, product_id, COUNT(product_id) AS qty')
        // ->get();
        //dd($result1);

        //$collection = $user->carts[0]->products->unique();    // Devuelve una coleccion de productos UNICOS del carrito (array de 1 nivel)

        //$collection = $user->carts[0]->products->groupBy('id')->values();    // Devuelve una coleccion de productos Agrupados por id comenzando el array en 0 (values()) del carrito (array de 1 nivel)
        //dd($collection);
        
        //dd($collection)->sum('price');    // Devuelve la suma total entre todos los productos
        
        // METODO 1
        //$result = collect($collection)->groupBy('id')->map(function ($item) { return array_merge(...$item->toArray());})->values()->toArray();
        //dd($result);

        // METODO 2
        //$grouped = $collection->groupBy('id');  // Agrupa la coleccion por id (los devuelve agrupados en un array cuyas claves son su id)
        //dd($grouped);

        //$db = DB::table('cart_product')->select('*')->where('cart_id', 1)->get();
        //dd($db);
        
        // ESTA CONSULTA DEVUELVE EL CARRITO DEL USUARIO AGRUPADO Y CON LOS ITEMS SUMADOS (AGRUPADOS) AL MENOS EN SQL
        //$cart_user = DB::select('SELECT *, count(id) as qty FROM `cart_product` WHERE cart_id = 1 GROUP by product_id');
        //dd($cart_user);

        //$prod = DB::table('cart_product')->select(DB::raw('count(product_id) as qty'))->groupBy('product_id')->get();
        //$prod = DB::table('cart_product')->distinct()->get();

        //dd($user->carts[0]->products[0]->category->name); // Devuelve el nombre de la categoria de ESE producto
        //dd($user->carts);   // Devuelve un array de carritos asociados al usuario
        //dd($user->carts[0]->products);    // Devuelve un array de productos del primer carrito del user
        //dd($user->carts->first());    // Devuelve el Primer Carrito del Usuario

        //$carts = Carts::find($id);

        //return view('customer.carts.show', ['carts' => $carts,]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // Si la cantidad es null, vuelve a la pagina anterior con un mensaje
        if ($request->prod_qty === null || $request->prod_qty == 0) {

            \Session::flash('alert-warning', 'Debe elegir una cantidad !!!');

            return redirect()->back()->with('message', 'Debe elegir una cantidad !!!'); // Vuelve a la pagina de donde vino con un mensaje
        
        }

        // Buscar el producto a modificar
        $cart_product = CartProduct::where('cart_id', $request->cart_id)->where('product_id', $request->edit_id)->firstOrFail();
        
        if ($request->prod_qty != $cart_product->product_qty) {

            $cart_product->product_qty = (int)$request->prod_qty;
            $cart_product->save();

            // // Agrega en la DB tantas filas como productos se hayan elegido
            // for ($i=0; $i < ((int)$request->qty - (int)$cart_product_qty); $i++) { 
            //     $new_cart_product = CartProduct::create([
            //         'cart_id' => $request->cart_id,
            //         'product_id' => $request->edit_id,
            //         'product_qty' => $request->prod_qty,
            //     ]);
            // }
            
        } else {

            \Session::flash('alert-warning', 'No se realizaron cambios !!!');

            return redirect()->back()->with('message', 'No se realizaron cambios !!!'); // Vuelve a la pagina de donde vino con un mensaje

            // // Elimina en la DB tantas filas como productos se hayan elegido
            // for ($i=0; $i < ((int)$cart_product_qty - (int)$request->qty); $i++) {
            //     $cart_product = CartProduct::where('cart_id', $request->cart_id)->where('product_id', $request->edit_id)->firstOrFail();
            //     $cart_product->delete();
            // }
        }

        \Session::flash('alert-success', 'Carrito actualizado correctamente !!!');

        return redirect()->back()->with('message', 'Carrito actualizado correctamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cart_product = CartProduct::where('cart_id', $request->cart_id)->where('product_id', $request->del_id)->firstOrFail();
        $cart_product->delete();

        // Se verifica si aun queda algun producto en el carrito, no la cantidad, sino si existe algun registro
        $verify_cart_qty = CartProduct::where('cart_id', $request->cart_id)->count();

        //dd($verify_cart_qty);

        if ($verify_cart_qty === 0) {

            $openCart = auth()->user()->cartInProgress();

            // Se modifica el estado del carrito
            $openCart->update([
                'status' => 'open'
            ]);

            //dd($openCart);

            \Session::flash('alert-danger', 'Carrito Vacío !!!');

            return redirect('/customer/cart')->with('message', 'Carrito Vacío !!!'); // Vuelve a la pagina de donde vino con un mensaje

        } else {

            \Session::flash('alert-danger', 'Producto eliminado del Carrito !!!');

            return redirect()->back()->with('message', 'Producto eliminado del Carrito !!!'); // Vuelve a la pagina de donde vino con un mensaje

        }
        

        // // Elimina en la DB tantas filas como productos se haya elegido
        // $cart_product_qty = CartProduct::where('cart_id', $request->cart_id)->where('product_id', $request->del_id)->count();
        // for ($i=0; $i < $cart_product_qty; $i++) {
        //     $cart_product = CartProduct::where('cart_id', $request->cart_id)->where('product_id', $request->del_id)->firstOrFail();
        //     $cart_product->delete();
        // }

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
