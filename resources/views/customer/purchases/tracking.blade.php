@extends('website.layouts.website')

@section('title')
Mis Ordenes
@endsection


@section('content')

<!-- =========================  COMPONENT TRACKING ========================= -->
<div class="container" id="orders">
    <div class="row" id="tracking">
        <article class="card" id="tracking">
            <header class="card-header"> My Orders / Tracking </header>
            <div class="card-body">
                <h6>Order ID: {{ $purchase->id }}</h6>
                <article class="card">
                    <div class="card-body row no-gutters">
                        <div class="col">
                            <strong>Delivery Estimate time:</strong> <br>16:40, 12 nov 2018
                        </div>
                        <div class="col">
                            <strong>Shipping company:</strong> <br> Fedex, | <i class="fa fa-phone"></i> +123467890
                        </div>
                        <div class="col">
                            <strong>Status:</strong> <br> Picked by the courier
                        </div>
                        <div class="col">
                            <strong>Tracking #:</strong> <br> 98765432123
                        </div>
                    </div>
                </article>

                <div class="tracking-wrap">
                    <div class="step active">
                        <span class="icon"> <i class="fa fa-check"></i> </span>
                        <span class="text">Order confirmed</span>
                    </div> <!-- step.// -->
                    <div class="step active">
                        <span class="icon"> <i class="fa fa-user"></i> </span>
                        <span class="text"> Picked by courier</span>
                    </div> <!-- step.// -->
                    <div class="step">
                        <span class="icon"> <i class="fa fa-truck"></i> </span>
                        <span class="text"> On the way </span>
                    </div> <!-- step.// -->
                    <div class="step">
                        <span class="icon"> <i class="fa fa-box"></i> </span>
                        <span class="text">Ready for pickup</span>
                    </div> <!-- step.// -->
                </div>


                <hr>
                <ul class="row">

                    @foreach( $purchase->cart->products as $product )
                    @if($product->stock > 0)
                    <li class="col-md-4">
                        <figure class="itemside  mb-3">
                            <div class="aside"><img src="{{ asset($product->image) }}" class="img-sm border"></div>
                            <figcaption class="info align-self-center">
                                <p class="title">{{ $product->name }}</p>
                                <span class="text-muted">{{ $product->currency . ' ' . $product->price }}</span>
                            </figcaption>
                        </figure>
                    </li>
                    @endif
                    @endforeach

                </ul>


                <p><strong>Note: </strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                <a href="{{ url('customer/order/history') }}" class="btn btn-light"> <i class="fa fa-chevron-left"></i>
                    Back
                    to orders</a>
            </div> <!-- card-body.// -->
        </article>
    </div> <!-- row.// -->
</div> <!-- container.// -->
<!-- =========================  COMPONENT TRACKING END.// ========================= -->

@endsection
