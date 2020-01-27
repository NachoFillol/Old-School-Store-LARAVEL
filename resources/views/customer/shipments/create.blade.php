@extends('website.layouts.website')

@section('title')
Detalle de envío
@endsection

@section('content')

<div class="container" id="shipping">

    <div class="row">
        <div class="col">

            <!-- <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                        data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
                @endforeach
            </div> -->
            <!-- Funciona enviando el mesaje a traves del flash() a Session::class en el controlador. Necesita las query JAVA -->

            <h4>Confirmacion de Compra 2</h4>
            <!--<h6>Usuario ID ({{$user->id}}) | Cantidad Items (<?= $openCart ? $openCart->products->count():0 ?>)</h6>-->

            <output>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Dirección de envío <i class="fas fa-address-card"></i></h4>
                        
                        @include('customer.shipments.form', [
                        'method' => 'post',
                        'url' => '/customer/purchase/shipment'
                        ])

                    </div> <!-- card-body.// -->
                </div> <!-- card .// -->
            </output>

        </div>
    </div>

</div>
@endsection