<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Purchase;
use App\Discount;
use App\Product;

class PurchasesController extends Controller
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
        // 1er PASO DE LA COMPRA (CUANDO SE DA CLIC EN COMPRAR EN CARRITO)

        $this->validate($request, [
            'cart_id' => 'required|integer|min:1'
        ]);

        $logued = \Auth::user();

        $openCart = $logued->carts()->latest()->first();
        //dd($openCart->purchases->isEmpty());
        if ($openCart->status === 'open' && $openCart->purchases->isEmpty()) {
            //$new_purchase = Purchase::create($request->all());
            $new_purchase = Purchase::create([
                'cart_id' => $request->cart_id,
                'shipment_id' => null,
                'paymentmethod_id' => 2,    // Tarjeta de Credito
                'paymentcard_id' => null,
                'discount_id' => null,
                'currency' => '$',
                'shipping_price' => 0,
                'tax_perc' => 0,
                'total_price' => 0,
                'invoice_url' => null,
                'comments' => null,
            ]);

        } elseif ($openCart->status === 'payment') {
            // Si esta en estado de carga de pago
            return redirect('/customer/purchase/payment');
        } elseif ($openCart->status === 'shipment') {
            // Si esta en estado de carga de envio
            return redirect('/customer/purchase/shipment');
        } else {
            // Si esta en estado de revision
            return redirect('/customer/purchase/review');
        }
        
        return redirect('/customer/purchase/payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // 6to PASO DE LA COMPRA

        $logued = \Auth::user();

        $openCart = $logued->carts()->openCart()->latest()->first();  // Trae el primero de los ultimos carritos abiertos

        //dd($openCart->products->isEmpty());

        // Si el carrito no esta en estado de envio y la compra no tiene dato de envio, redirige
        if ( ! $openCart->purchases->first() && $openCart->status !== 'shipment' ) {
           return redirect('/customer/cart');
        }

        // Se modifica el estado del carrito
        $openCart->update([
            'status' => 'review'
        ]);
        
        return view('customer.purchases.show', [
            'user' => $logued, 
            'openCart' => $openCart, 
            'sub1' => 0, 
            'sub2' => 0, 
            'sub3' => 0,
            'subtot' => 0,
            'total' => 0,
            'envio' => 120,
            'iva' => 21,
            'oferta' => $openCart->purchases->first()->discount ? $openCart->purchases->first()->discount->discount_perc : 0,
            'moneda' => null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // 7mo PASO DE LA COMPRA

        // APLICA UN DESCUENTO GRAL A LA COMPRA
        if ($request->discount_code !== null) {

            //Busca el valor del descuento y lo graba en purchases
            $discount = Discount::where("code", "LIKE", $request->discount_code)->first();
            
            if ($discount) {

                $logued = \Auth::user();

                $openCart = $logued->carts()->openCart()->latest()->first();  // Trae el primero de los ultimos carritos abiertos
                
                //$purchase = Purchase::find($request->purchase_id);
                $openCart->purchases->first()->update([
                    'discount_id' => $discount->id
                ]);

                // Si se aplica descuento, redirige con mensaje
                \Session::flash('alert-success', 'Descuento aplicado correctamente !!!');
                //dd(\Session::all());
                return redirect()->back()->with('message', 'Descuento aplicado correctamente !!!');

            }
            
            // Si no se encuentra el descuento, redirige con mensaje
            \Session::flash('alert-warning', 'Descuento no es valido !!!');
            //dd(\Session::all());
            return redirect()->back()->with('message', 'Descuento no es valido !!!');
            
        } else {
            // Si no se envia ningun descuento, redirige con mensaje
            \Session::flash('alert-warning', 'No se aplico ningún descuento !!!');
            //dd(\Session::all());
            return redirect()->back()->with('message', 'No se aplico ningún descuento !!!');
        }

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
        // 8vo PASO DE LA COMPRA

        // CONFIRMA LA COMPRA Y CIERRA EL CARRITO

        $logued = \Auth::user();

        $openCart = $logued->carts()->openCart()->latest()->first();  // Trae el primero de los ultimos carritos abiertos

        //$purchase = Purchase::find($request->purchase_id);
        $openCart->purchases->first()->update([
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'tax_perc' => $request->tax_perc
        ]);

        // Se modifica el estado del carrito
        $openCart->update([
            'status' => 'closed'
        ]);

        // Modifica el Stock de c/producto
        foreach ($openCart->products as $product) {
            $prod_qty = $product->pivot->product_qty;
            $prod_to_upd = Product::find($product->id);
            $prod_to_upd->update([
                'stock' => $prod_to_upd->stock - $prod_qty
            ]);
        }

        \Session::flash('alert-success', 'Gracias por tu compra !!!');
        return redirect('/')->with('message', 'Gracias por tu compra !!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 8vo PASO DE LA COMPRA

        // ANULA LA COMPRA CANCELANDO EL CARRITO

        $logued = \Auth::user();

        $openCart = $logued->carts()->openCart()->latest()->first();  // Trae el primero de los ultimos carritos abiertos

        //$purchase = Purchase::find($request->purchase_id);
        // $openCart->purchases->first()->update([
        //     'total_price' => 0,
        //     'shipping_price' => 0,
        //     'tax_perc' => 0
        // ]);

        // Se modifica el estado del carrito
        $openCart->update([
            'status' => 'cancelled'
        ]);

        \Session::flash('alert-danger', 'Orden Cancelada !!!');
        return redirect('/')->with('message', 'Orden Cancelada !!!');

    }
}
