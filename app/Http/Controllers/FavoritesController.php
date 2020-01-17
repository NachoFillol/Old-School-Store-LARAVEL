<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Permite usar metodo table() en DB

use App\Favorite;
use App\User;
use App\Category;
use App\Product;


class FavoritesController extends Controller
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
        
        $new_fav = Favorite::create([
            'user_id' => $request->user_id,
            'product_id' => $request->add_del
        ]);

        \Session::flash('alert-success', 'Producto agregado a Favoritos !!!');

        return redirect()->back()->with('message', 'Producto agregado a Favoritos !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $logued = \Auth::user();

        $openCart = $logued->carts()->openCart()->first();

        return view('customer.favorites.show', ['user' => $logued, 'openCart' => $openCart]);

        //$user = User::where('code', $user_code)->firstOrFail(); // Devuelve un user o falla. Con ->get() lo devuelve dentro de un array [0]
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
    public function update(Request $request)
    {
        $favorite = Favorite::where([['user_id', $request->user_id], ['product_id', $request->add_del]])->firstOrFail();
        
        $favorite->delete();

        \Session::flash('alert-danger', 'Producto eliminado de Favoritos !!!');

        return redirect()->back()->with('message', 'Producto eliminado de Favoritos !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($request);
        //$favorite = Favorite::where([['user_id', $request->user_id], ['product_id', $request->add_del]])->firstOrFail();
        //dd($favorite);
        //$favorite->delete();

        //\Session::flash('alert-danger', 'Producto eliminado de Favoritos !!!');

        //return redirect()->back()->with('message', 'Producto eliminado de Favoritos !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }
}
