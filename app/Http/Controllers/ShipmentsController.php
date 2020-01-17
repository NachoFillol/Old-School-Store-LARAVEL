<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Shipment;
use App\Address;
use App\UserAddress;
use App\Category;

class ShipmentsController extends Controller
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
    public function create(Request $request)
    {
        // 4to PASO DE LA COMPRA

        $logued = \Auth::user();

        $openCart = $logued->carts()->openCart()->latest()->first();

        // Si No hay una Compra asociada a un carrito, redirige
        if (! $openCart->purchases->first() && $openCart->status !== 'payment') {
            return redirect('/customer/cart');

        } elseif ($openCart->purchases->first()->shipment_id !== null) {
            // Si la compra ya tiene una direccion de envio, redirige al prox paso
            return redirect('/customer/purchase/review');
        }

        // Se modifica el estado del carrito
        $openCart->update([
            'status' => 'shipment'
        ]);

        $states = \DB::table('states')->get();

        return view('customer.shipments.create', ['shipment' => new Shipment, 'states' => $states, 'openCart' => $openCart, 'user' => $logued]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 5to PASO DE LA COMPRA

        // Esto valida si los datos estan completos, sino redirige a la pagina de origen !!!
        $this->validate($request, [
            'user_id' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
        ]);

        $new_address = Address::Create($request->all());

        // Se agrega una nueva direccion de envio del tipo address
        $new_shipment = Shipment::Create([
            'address_id' => $new_address->id,
            'shipping_day' => null,
            'reception_day' => null
        ]);

        $logued = \Auth::user();

        $openCart = $logued->carts()->latest()->first();

        $purchase = $openCart->purchases->first();

        // Se agrega el dato de la direccion de envio
        $purchase->update([
            'shipment_id' => $new_shipment->id
        ]);

        // Se agrega una nueva direccion de envio del tipo user_address
        $new_user_address = UserAddress::Create([
            'user_id' => $logued->id,
            'address_id' => $new_address->id,
        ]);

        \Session::flash('alert-success', 'Dirección registrada correctamente !!!');

        return redirect('/customer/purchase/review')->with('message', 'Dirección registrada correctamente !!!'); // Vuelve a la pagina de donde vino con un mensaje
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
