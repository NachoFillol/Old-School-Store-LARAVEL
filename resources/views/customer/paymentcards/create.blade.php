@extends('website.layouts.website')

@section('title')
Medio de Pago
@endsection

@section('content')

<div class="container" id="payment">

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

            <h4>Confirmacion de Compra 1</h4>
            <!--<h6>Usuario ID ({{$user->id}}) | Cantidad Items (<?= $openCart ? $openCart->products->count():0 ?>)</h6>-->

            <output>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Metodo de Pago <i class="fas fa-money-check-alt"></i></h4>

                        @include('customer.paymentcards.form', [
                        'method' => 'post',
                        'url' => '/customer/purchase/payment'
                        ])

                    </div> <!-- card-body.// -->
                </div> <!-- card .// -->
            </output>

        </div>
    </div>

</div>
@endsection
