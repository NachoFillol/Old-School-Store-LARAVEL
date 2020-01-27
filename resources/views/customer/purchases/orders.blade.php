@extends('website.layouts.website')

@section('title')
Mis Ordenes
@endsection


@section('content')

<!-- =========================  COMPONENT MYORDER 1 ========================= -->
<div class="container" id="orders">
    <div class="row">

        @include('customer.purchases.sidebar')

        @forelse ($closedCarts as $cart)

        <?php $purchase = $cart->purchases ?>
        <?php $paymentcard = $purchase->paymentcard ?>

        <main class="col-md-9">
            <article class="card">
                <header class="card-header">
                    <strong class="d-inline-block mr-3">Orden ID: {{ $purchase->id }} | Transaccion ID: {{ $paymentcard->id }}</strong>
                    <span>Fecha Orden: {{ $purchase->created_at->format('d-m-Y') }} | Ultima modificacion:
                        {{ $purchase->updated_at->format('d-m-Y') }}</span>
                </header>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted">Enviada a:</h6>
                            <p>{{ $user->getNombreCompleto() }}<br>
                                Telefono {{ $user->phone }} Email: {{ $user->email }} <br>
                                Ubicacion:
                                {{ $purchase->shipment->address->address . ', ' . $purchase->shipment->address->city . ', ' . $purchase->shipment->address->state }}
                                <br>
                                Z.I.P: {{ $purchase->shipment->address->zip }}
                            </p>
                            <form id="comments-form" action="" method="post">
                                @csrf
                                @method('post')
                                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                <div class="form-group">
                                    <label for="comments">Deja un comentario sobre esta compra</label>
                                    <div>
                                        <textarea name="comments" class="form-control" id="comments" rows="2"
                                            <?= ($purchase->comments !== null) ? 'disabled' : null ?>>{{ $purchase->comments }}</textarea>
                                        @if ($purchase->comments === null)
                                        <button type="submit" class="btn btn-sm btn-outline-warning">Enviar</button>
                                        <input type="reset" class="btn btn-sm btn-outline-info" value="Reset">
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
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
                            <a href="{{ url('customer/order/tracking') }}" class="btn btn-outline-primary"
                                onclick="event.preventDefault(); document.getElementById('tracking-form').submit();">
                                Track order
                            </a>
                        </div>
                    </div> <!-- row.// -->
                </div> <!-- card-body .// -->

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            @foreach( $cart->products as $product )
                            <tr>
                                <td width="65">
                                    <img style="{{ @(! $product->stock > 0) ? 'opacity:0.25' : 'null' }}"
                                     src="{{ asset($product->image) }}" class="img-xs border">
                                </td>
                                <td>
                                    <p class="title mb-0"> {{ $product->name }} </p>
                                    <var class="price text-muted">Precio actual: {{ $product->currency . ' ' . $product->price }} {{@($product->stock == 0) ? '(N/D)':null}}</var>
                                </td>
                                <td> Cant <br> {{ $product->pivot->product_qty }} </td>
                                <!-- <td> Cat <br> <small>{{ $product->category->name }}</small> </td> -->
                                <td> Vendedor <br> Old School Store </td>
                                <td width="250">
                                    <!-- <a href="#" class="btn btn-outline-primary">Track order</a>  -->
                                    @if($product->stock > 0)
                                    <a href="{{ url('/product/'.$product->id) }}" class="btn btn-light"> Detalle</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive .end// -->
            </article> <!-- order-group.// -->

            <!-- VISTAS DE PAGINAS -->
            <div>{{$closedCarts->links()}}</div>

        </main>

        @empty
        <main class="col-md-9">
            <article class="card">
                <header class="card-header">
                    <strong class="d-inline-block mr-3">Orden ID:</strong>
                    <span></span>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted">NO TIENE ORDENES REALIZADAS</h6>
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
        </main>
        @endforelse

    </div> <!-- row.// -->
</div> <!-- container.// -->
<!-- =========================  COMPONENT MYORDER 1 END.// ========================= -->

@if (isset($purchase))
@include('customer.purchases.tracking-form')
@endif

@endsection
