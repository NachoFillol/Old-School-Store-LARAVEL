@extends('website.layouts.website')

@section('title')
Mis Ordenes
@endsection


@section('content')

<!-- =========================  COMPONENT MYORDER 2 ========================= -->
<div class="container" id="orders">
    <div class="row">

        @include('customer.purchases.sidebar')

        @forelse ($closedCarts as $cart)
        
        <?php $purchase = $cart->purchases ?>
        <?php $paymentcard = $purchase->paymentcard ?>

        <div class="col-md-9">
            <article class="card order-group" id="transaction">
                <header class="card-header">
                    <b class="d-inline-block mr-3">Transaccion ID: {{ $paymentcard->id }} | Orden ID: {{ $purchase->id }}</b>
                    <span>Fecha Pago: {{ $paymentcard->created_at->format('d-m-Y') }}</span>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-muted">Medio de Pago</h6>
                            <span class="text-success">
                                <i class="<?= $paymentcard->getIcon() ? 'fab fa-cc-'.$paymentcard->getIcon() : 'far fa-credit-card' ?>"></i>
                                {{ ucfirst($paymentcard->getIcon() ?? 'unknown') }} ****
                                {{ substr($paymentcard->number, -4) }}
                            </span>
                            <p> Subtotal: ${{ $purchase->subtotal }} <br>
                                Dtos.: - {{ $purchase->total_discount }} % <br>
                                Cargo envío: ${{ $purchase->shipping_cost }} <br>
                                Impuesto: {{ $purchase->taxes }} %<br>
                                <span class="b">Total: ${{ $purchase->final_price }} </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Contacto</h6>
                            <p>{{ $user->getNombreCompleto() }} <br> {{ $user->phone }} <br> {{ $user->email}} </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Dirección de envío</h6>
                            <p> {{ $purchase->shipment->address->address . ', ' . $purchase->shipment->address->city . ', ' . $purchase->shipment->address->state }}
                            </p>
                        </div>
                    </div> <!-- row.// -->
                    <hr>
                    <ul class="row">

                        @foreach( $cart->products as $product )
                        <li class="col-md-4">
                            <figure class="itemside  mb-3">
                                <div class="aside"><img style="{{ @(! $product->stock > 0) ? 'opacity:0.25' : 'null' }}"
                                 src="{{ asset($product->image) }}" class="img-sm border"></div>
                                <figcaption class="info align-self-center">
                                    <p class="title">{{ $product->name }}</p>
                                    <span class="text-muted">Precio actual: {{ $product->currency . ' ' . $product->price }}  {{@($product->stock == 0) ? '(N/D)':null}}</span>
                                </figcaption>
                            </figure>
                        </li>
                        @endforeach

                    </ul>
                </div> <!-- card-body .// -->
            </article>
        </div> <!-- col .// -->

        @empty
        <div class="col-md-9">
            <article class="card">
                <header class="card-header">
                    <strong class="d-inline-block mr-3">Transacción ID:</strong>
                    <span></span>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted">NO TIENE TRANSACCIONES REALIZADAS</h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">NO TIENE MEDIOS DE PAGO</h6>
                        </div>
                    </div> <!-- row.// -->
                </div> <!-- card-body .// -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        </tbody>
                    </table>
                </div> <!-- table-responsive .end// -->
            </article> <!-- order-group.// -->
        </div>
        @endforelse

    </div> <!-- row.// -->
</div> <!-- container.// -->
<!-- =========================  COMPONENT MYORDER 2 END.// ========================= -->

@if (isset($purchase))
@include('customer.purchases.tracking-form')
@endif

@endsection
