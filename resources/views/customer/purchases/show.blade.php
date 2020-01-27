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
                                        <div class="aside"><img style="width: 40px; height: 40px;
                                        {{ @(! $product->stock > 0) ? 'opacity:0.25' : 'null' }}"
                                                src="{{ asset($product->image) }}" class="border img-xs"></div>
                                        @if($product->stock > 0)     
                                        <figcaption class="info">
                                            <p> {{ $product->name }} </p>
                                            <span>{{ $product->pivot->product_qty }}
                                                x <?= $product->currency . number_format($product->price, 2, ',', '') ?>
                                                = Total:
                                                <?= $product->currency . number_format($product->price * $product->pivot->product_qty, 2, ',', '') ?>
                                            </span>
                                        </figcaption>
                                        @else
                                        <figcaption class="info">
                                            <p> {{ $product->name }} </p>
                                            <span>{{ '0' }}
                                                x <?= $product->currency . '0,00' ?>
                                                = Total:
                                                <?= $product->currency . '0,00' ?>
                                            </span>
                                        </figcaption>
                                        @endif
                                    </figure>
                                </div> <!-- col.// -->
                                
                                <!-- Hace la cuenta parcial -->
                                @if($product->stock > 0)
                                <?php $subtot = $subtot + ($product->price * $product->pivot->product_qty) ?>
                                @else
                                <?php $subtot = $subtot ?>
                                @endif
                                
                                @endforeach

                            </div> <!-- row.// -->
                        </article> <!-- card-body.// -->

                        <article class="card-body border-top">

                        <!-- Calcula el Descuento -->
                        <?php $subtot_dto = round($subtot * ($oferta / 100), 2 , PHP_ROUND_HALF_DOWN) ?>
                        <!-- Calcula el IVA -->
                        <?php $subtot_iva = round(($subtot - $subtot_dto + $envio) * ($iva / 100), 2 , PHP_ROUND_HALF_DOWN) ?>

                            <dl class="row">
                                <!-- Subtotal -->
                                <dt class="col-sm-10">Subtotal: <span class="float-right text-muted"><?= $openCart->products->count() ?>
                                        item / <?= $openCart->products->sum('pivot.product_qty') ?> uni</span>
                                </dt>

                                <dd class="col-sm-2 text-right">
                                    <strong>
                                        <?= $product->currency . number_format(round($subtot, 2 , PHP_ROUND_HALF_DOWN), 2, ',', '') ?>
                                    </strong>
                                </dd>

                                <!-- Descuento -->
                                <dt class="col-sm-10">Descuento: <span class="float-right text-muted">Oferta
                                        -<?= number_format($oferta, 2, ',', '') ?>%</span>
                                </dt>

                                <dd class="col-sm-2 text-danger text-right">
                                    <strong>
                                        <?= $product->currency . number_format($subtot_dto, 2, ',', '') ?>
                                    </strong>
                                </dd>

                                <!-- Cargos por envío -->
                                <dt class="col-sm-10">Cargo por Envío: <span class="float-right text-muted">Envío express</span></dt>
                                
                                <dd class="col-sm-2 text-right"><strong>$<?= number_format($envio, 2, ',', '') ?></strong></dd>

                                <!-- Impuestos -->
                                <dt class="col-sm-10">Impuesto: <span class="float-right text-muted"><?= number_format($iva, 2, ',', '') ?>%</span></dt>

                                <dd class="col-sm-2 text-right text-success">
                                    <strong>
                                        <?= $product->currency . number_format($subtot_iva, 2 , ',', '') ?>
                                    </strong>
                                </dd>

                                <!-- Total -->
                                <dt class="col-sm-9">Total:</dt>

                                <?php $total = $subtot - $subtot_dto + $envio + $subtot_iva ?>

                                <dd class="col-sm-3 text-right" id="total-price">
                                    <strong class="h5 text-dark">
                                        <?= $product->currency . number_format($total, 2, ',', '') ?>
                                    </strong>
                                </dd>
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

                                    <!-- Hace la cuenta parcial -->
                                    @if($product->stock > 0)
                                    <?php $subt = $subt + ($product->price * $product->pivot->product_qty) ?>
                                    @else
                                    <?php $subt = $subt ?>
                                    @endif
                                    
                                    <figure class="itemside mb-3">
                                        <div class="aside"><img style="{{ @(! $product->stock > 0) ? 'opacity:0.25' : 'null' }}" 
                                            src="{{ asset($product->image) }}" class="img-sm border">
                                        </div>
                                        <figcaption class="info align-self-center" id="dropdown">
                                            <p class="title"> <?= $product->name ?> </p>
                                            <div class="price-delete">
                                                @if($product->stock > 0)
                                                <div class="price">
                                                    <?= $product->currency . number_format($product->price * $product->pivot->product_qty, 2, ',', '') ?>
                                                    <small><?= '(' . $product->pivot->product_qty . ' uni)' ?></small>
                                                </div> <!-- price-wrap.// -->
                                                @else
                                                <div class="price">
                                                    <?= $product->currency . '0,00' ?>
                                                    <small><?= '(0 uni)' ?></small>
                                                </div> <!-- price-wrap.// -->
                                                @endif

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
                                            class="h5 price">$<?= number_format($subt, 2, ',', '') ?></strong></div>
                                    <div class="price-wrap text-center py-3">Final: <strong
                                            class="h5 price">$<?= number_format($total, 2, ',', '') ?></strong></div>

                                    <div class="row" id="puchase-buttons">
                                        <form action="{{ url('customer/purchase/confirm') }}" method="post" id="buy-button">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="total_price" value="{{ $total }}">
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
