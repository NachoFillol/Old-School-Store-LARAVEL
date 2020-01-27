<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PaymentCard;
use App\User;
use App\Category;

class PaymentCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$payments = PaymentCards::paginate(5);

        //return view('website.paymentcards.show', ['payments' => $payments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // 2do PASO DE LA COMPRA

        $openCart = auth()->user()->cartInProgress();

        // Si No hay una Compra asociada a un carrito, redirige
        if (! $openCart->purchases()->first() && $openCart->status !== 'open') {

            return redirect('/customer/cart');

        } elseif ($openCart->purchases()->first()->paymentcard_id !== null) {

            // Si la compra ya tiene una tarjeta asociada, redirige al prox paso
            return redirect('/customer/purchase/shipment');
        }

        // Se modifica el estado del carrito
        $openCart->update([
            'status' => 'payment'
        ]);

        return view('customer.paymentcards.create', [
            'paymentcard' => new PaymentCard, 
            'openCart' => $openCart, 
            'user' => auth()->user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 3er PASO DE LA COMPRA

        // Esto valida si los datos estan completos, sino redirige a la pagina de origen !!!
        $this->validate($request, [
            'user_id' => 'required|integer|min:1',
            'owner' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'month_expiration' => 'required|string|max:2',
            'year_expiration' => 'required|string|max:4',
            'security_code' => 'required|string|max:3',
        ]);
        
        $new_paymentcard = PaymentCard::Create($request->all());

        $openCart = auth()->user()->cartInProgress();

        $purchase = $openCart->purchases()->first();

        // Se agrega el dato de la tarjeta a la compra
        $purchase->update([
            'paymentcard_id' => $new_paymentcard->id
        ]);

        \Session::flash('alert-success', 'Medio de pago registrado correctamente !!!');

        return redirect('/customer/purchase/shipment')->with('message', 'Medio de pago registrado correctamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = PaymentCard::find($id);

        return view('website.paymentcards.show', ['payments' => $payments]);
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
        $product = Product::find($id);

        $product->update($request-all());

        return redirect('/products/' . $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = PaymentCard::findOrFail($id);

        $payment->delete();

        return redirect('/paymentcards');
    }

    public function test(Request $request) {
        dd($request);
    }
}
