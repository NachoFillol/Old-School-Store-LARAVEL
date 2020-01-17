@extends('website.layouts.website')

@section('title')
Confirmacion Compra
@endsection


@section('content')

<div class="container" id="review-cart">

    <h4>Confirmacion de Compra 3</h4>
    <!--<div class="row">-->
    <div class="col">
        <!--<h4>Confirmacion de Pago </h4>-->
        <!--<h6>Usuario ID ({{ $user->code }}) | Cantidad Items (<?= $openCart ? $openCart->products->count():0 ?>) | Total Productos ({{ $openCart ? $openCart->products->sum('pivot.product_qty') : '0'}})</h6>-->

        <div class="row">
            <aside class="col-md-9">
                <output id="review">
                    <div class="card">
                        <article class="card-body">
                            <header class="mb-4">
                                <h4 class="card-title">Revisión de Compra</h4>
                            </header>
                            <div class="row">

                                @if ( $openCart->products->isNotEmpty() )

                                @foreach ($openCart->products as $product)

                                <div class="col-md-6">
                                    <figure class="itemside  mb-3">
                                        <div class="aside"><img style="width: 40px; height: 40px"
                                                src="{{ asset($product->image) }}" class="border img-xs"></div>
                                        <figcaption class="info">
                                            <p> {{ $product->name }} </p>
                                            <span>{{ $product->pivot->product_qty }}
                                                x <?= $product->currency . number_format($product->price, 2, ',', '') ?>
                                                = Total:
                                                <?= $product->currency . number_format($product->price * $product->pivot->product_qty, 2, ',', '') ?>
                                            </span>
                                        </figcaption>
                                    </figure>
                                </div> <!-- col.// -->

                                <?php $sub1 = $sub1 + ($product->price * $product->pivot->product_qty) ?>
                                <!-- Hace la cuenta parcial -->
                                
                                @endforeach

                            </div> <!-- row.// -->
                        </article> <!-- card-body.// -->

                        <article class="card-body border-top">

                            <dl class="row">
                                <dt class="col-sm-10">Subtotal: <span class="float-right text-muted"><?= $openCart->products->count() ?>
                                        item / <?= $openCart->products->sum('pivot.product_qty') ?> uni</span>
                                </dt>
                                <dd class="col-sm-2 text-right">
                                    <strong>
                                        <?= $product->currency . number_format(round($sub1, 2 , PHP_ROUND_HALF_DOWN), 2, ',', '') ?>
                                    </strong></dd>

                                <dt class="col-sm-10">Descuento: <span class="float-right text-muted">Oferta
                                        -<?= $oferta ?>%</span></dt>
                                <dd class="col-sm-2 text-danger text-right">
                                    <strong>
                                        <?= $product->currency . number_format(round($sub2 = ($sub1 * (1 - ($oferta / 100))), 2 , PHP_ROUND_HALF_DOWN), 2, ',', '') ?>
                                    </strong></dd>

                                <dt class="col-sm-10">Cargo por Envío: <span class="float-right text-muted">Envío
                                        express</span></dt>
                                <dd class="col-sm-2 text-right"><strong>$<?= $envio ?></strong></dd>

                                <dt class="col-sm-10">Impuesto: <span class="float-right text-muted"><?= $iva ?>%</span>
                                </dt>
                                <dd class="col-sm-2 text-right text-success">
                                    <strong>
                                        <?= $product->currency . number_format(round($subtot = ($sub2 + $envio) * (($iva / 100) + 1), 2 , PHP_ROUND_HALF_DOWN), 2 , ',', '') ?>
                                    </strong></dd>

                                <dt class="col-sm-9">Total:</dt>
                                <?php $total = number_format(round($subtot, 2, PHP_ROUND_HALF_DOWN), 2, ',', '') ?>
                                <dd class="col-sm-3 text-right" id="total-price">
                                    <strong class="h5 text-dark">
                                        {{ $product->currency . $total }}
                                    </strong></dd>
                            </dl>

                            @endif

                        </article> <!-- card-body.// -->
                    </div>
                </output>
            </aside>

            <aside class="col-md-3">

                <output>
                <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/customer/purchase/review') }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <label>Tiene un Cupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discount_code" placeholder="Codigo">
                                        <span class="input-group-append">
                                            <button type="submit" name="purchase_id" 
                                            value="{{ $openCart->products ? $openCart->purchases->first()->id:null }}" 
                                            class="btn btn-primary">Aplicar</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- card-body.// -->
                </div> <!-- card.// -->
                </output>

                <output id="dropdown">
                    <div class="card">
                        <div class="card-body">
                            <p>Confirmar Compra</p>
                            <div class="dropdown">
                                <a href="#" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown">
                                    Mostrar <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu p-3 dropdown-menu-right" style="min-width:280px;">

                                    @if ( $openCart->products->isNotEmpty() )
                                    @foreach ($openCart->products as $product)

                                    <?php $sub3 = $sub3 + $product->price * $product->pivot->product_qty ?>
                                    <!-- Hace la cuenta parcial -->

                                    <figure class="itemside mb-3">
                                        <div class="aside"><img style="" src="{{ asset($product->image) }}"
                                                class="img-sm border"></div>
                                        <figcaption class="info align-self-center" id="dropdown">
                                            <p class="title"> <?= $product->name ?> </p>
                                            <div class="price-delete">
                                                <div class="price">
                                                    <?= $product->currency . number_format($product->price * $product->pivot->product_qty, 2, ',', '') ?>
                                                    <small><?= '(' . $product->pivot->product_qty . ' uni)' ?></small>
                                                </div> <!-- price-wrap.// -->

                                                @if ($openCart->products->count() > 1)
                                                <!-- Botón Eliminar del carrito, solo si hay mas 1 item -->
                                                <form action="{{ url('customer/cart/add-del') }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <input type="hidden" name="cart_id" value="{{ $openCart->id }}">
                                                    <button class="btn btn-sm float right" title="Eliminar de la Compra"
                                                        name="del_id" value="{{ $product->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endif

                                            </div>
                                        </figcaption>
                                    </figure>

                                    @endforeach
                                    @endif

                                    <div class="price-wrap text-center py-3 border-top">Subtotal: <strong
                                            class="h5 price">$<?= number_format($sub3, 2, ',', '') ?></strong></div>
                                    <div class="price-wrap text-center py-3">Final: <strong
                                            class="h5 price">$<?= number_format($subtot, 2, ',', '') ?></strong></div>

                                    <div class="row" id="puchase-buttons">
                                        <form action="{{ url('customer/purchase/confirm') }}" method="post" id="buy-button">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="total_price" value="{{ $total}}">
                                        <input type="hidden" name="shipping_price" value="{{ $envio }}">
                                        <input type="hidden" name="tax_perc" value="{{ $iva }}">
                                            <button type="submit" name="purchase_id" value="{{ $openCart->products ? $openCart->purchases->first()->id:null }}" 
                                                class="btn btn-primary btn-block"
                                                style="@if($openCart) <?= $openCart->products->isEmpty() ? 'background-color: gray':null ?> @endif"
                                                @if($openCart) <?= $openCart->products->isEmpty() ? 'disabled':null ?> @endif> 
                                                Confirmar
                                            </button>
                                        </form>

                                        <form action="{{ url('customer/purchase/confirm') }}" method="post" id="buy-button">
                                        @csrf
                                        @method('delete')
                                        <!-- <input type="hidden" name="cart_id" value="<?= $openCart ? $openCart->id:null ?>"> -->
                                            <button type="submit" name="purchase_id" value="{{ $openCart->products ? $openCart->purchases->first()->id:null }}" 
                                                class="btn btn-danger btn-block"
                                                style="@if($openCart) <?= $openCart->products->isEmpty() ? 'background-color: gray':null ?> @endif"
                                                @if($openCart) <?= $openCart->products->isEmpty() ? 'disabled':null ?> @endif> 
                                                Cancelar
                                            </button>
                                        </form>
                                        <!-- <a href="" class="btn btn-primary btn-block"> Confirmar </a> -->
                                    </div>

                                </div> <!-- drowpdown-menu.// -->
                            </div> <!-- dropdown.// -->

                        </div> <!-- card-body.// -->
                    </div> <!-- card.// -->
                </output>

            </aside>


        </div>

    </div>
    <!--</div>-->

</div>

@endsection
