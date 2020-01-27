<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Discount;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $closedCarts = auth()->user()->carts()->with('purchases')->closedCarts()->paginate(1);

        return view('customer.purchases.orders', [
            'user' => auth()->user(), 
            'closedCarts' => $closedCarts, 
            'card_number' => null, 
            'card_logo' => null,
            'card_name' => null,
            'subtot' => 0
        ]);

        //dd($closedCarts->first()->purchases()->first()->paymentcard()->first()->number);  // Devuelve el numero
        //dd($closedCarts[0]->purchases()->first()->discount());
        //dd(Discount::find(13)->purchases);
        //dd($closedCarts[0]->purchases()->first()->paymentcard()->first()->number);  // Devuelve el numero
        //dd($closedCarts->items()[0]->purchases()->first()->paymentcard()->first()->number);  // Devuelve el numero
        //dd($closedCarts->toArray()['data'][0]['purchases']);    // Array de Purchase
        //dd($logued->carts()->get()[0]->purchases()->first());   // Devuelve la compra del 1er carrito
        //dd($logued->carts()->closedCarts()->get()); // Devuelve TODOS los carritos 'closed' del usuario
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request)
    {
        $this->validate($request, [
            'comments' => 'required',
        ]);

        $cart = Purchase::find($request->purchase_id)->cart()->first();

        $purchase = Purchase::find($request->purchase_id);

        // Comprobamos si la peticion con id de la compra coincide con la del usuario logueado
        // y si la compra ya no tenia un comentario
        if ($cart->user_id === auth()->user()->id && $purchase->comments === null) {

            $purchase->update([
                'comments' => $request->comments
            ]);

            \Session::flash('alert-warning', 'Comentario enviado !!!');

            return redirect('/customer/order/history')->with('message', 'Comentario enviado !!!'); // Vuelve a la pagina de donde vino con un mensaje

        } else {

            \Session::flash('alert-danger', 'Ya existe un comentario !!!');

            return redirect('/customer/order/history')->with('message', 'Ya existe un comentario !!!'); // Vuelve a la pagina de donde vino con un mensaje
        
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trans()
    {
        $closedCarts = auth()->user()->carts()->closedCarts()->paginate(1);

        return view('customer.purchases.transaction', [
            'user' => auth()->user(),
            'closedCarts' => $closedCarts,     
        ]);

        //dd($closedCarts[0]->purchases()->first()->paymentcard()->first());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        
        return view('customer.purchases.tracking', ['user' => auth()->user(), 'purchase' => $purchase]);
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
        //
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
