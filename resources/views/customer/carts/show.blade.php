@extends('website.layouts.website')

@section('title')
Mi Carrito
@endsection


@section('content')

<div class="container" id="mi-carrito">

    <div class="row">
        <div class="col">
            <h4>Mi Carrito <i class="fa fa-shopping-cart" aria-hidden="true"></i></h4>
            <h6>Cod Usuario ({{ $user->code }}) | Cantidad Items (<?= $openCart ? $openCart->products->count():0 ?>) | Total Productos ({{ $openCart ? $openCart->products->sum('pivot.product_qty') : '0'}})</h6>

            <output>
                <article class="card">
                    <header class="card-header"> Mi Carrito </header>
                    <div class="row">

                        <aside class="col-lg-9">

                            <div class="card">

                                <div class="table-responsive">

                                    <table class="table table-borderless table-shopping-cart">
                                        <thead class="text-muted">
                                            <tr class="small text-uppercase">
                                                <th scope="col" width="140">Producto</th>
                                                <th scope="col" width="80">Stock</th>
                                                <th scope="col" width="120">Cantidad</th>
                                                <th scope="col" width="120">Precio</th>
                                                <th scope="col" class="text-right d-none d-md-block" width="200"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ( $openCart )
                                            @foreach ($openCart->products as $product)
                                            
                                            <!-- Agrupa los productos del carrito con $product->id como su indice -->
                                            <!-- <php $prod_qty = $openCart->products->groupBy('id')[$product->id] ?> -->
                                            <!-- Consulta si el producto existe como favorito, sino devuelve null -->
                                            <?php $is_favorite = $user->favorites->where('id', $product->id)->first() ?>
                                            
                                            <tr>
                                                <td>
                                                    <figure class="itemside align-items-center">
                                                        <div class="aside"> <img style="width: 80px; height: 80px"
                                                                src="{{ asset($product->image) }}" class="img-sm">
                                                        </div>
                                                        <figcaption class="info">
                                                            <a href="{{ url('product/'.$product->id) }}"
                                                                class="title text-dark">{{ $product->name }}</a>
                                                            <p class="small text-muted">
                                                                Codigo: {{ $product->code }}
                                                                <br>
                                                                Categoria: <a
                                                                    href="{{ url('category/'.$product->category_id) }}">{{ $product->category->name }}</a>
                                                                <br>
                                                                Modelo: {{ $product->model }}
                                                                <br>
                                                                Calidad: {{ $product->quality }}</p>
                                                        </figcaption>
                                                    </figure>
                                                </td>
                                                
                                                <td><div>{{ $product->stock }} uni</div></td>

                                                <td>
                                                
                                                    <form action="{{ url('customer/cart') }}"
                                                        method="post" style="display: inline-flex">
                                                        @csrf
                                                        @method('patch')
                                                        
                                                        <!-- Quantity Input mediante Option + Stock -->
                                                        <select class="form-control" id="prod-qty" name="prod_qty">
                                                            @for ($i = 0; $i < $product->stock; $i++)
                                                            <option <?= ($product->pivot->product_qty == $i+1) ? 'selected':null ?> 
                                                            value="{{ $i+1 }}">{{ $i+1 }}</option>
                                                            @endfor
                                                        </select>
                                                        <input type="hidden" name="cart_id" value="{{ $openCart->id }}">
                                                        <button class="btn btn-sm btn-success"
                                                            title="Actualizar" name="edit_id"
                                                            value="{{ $product->id }}">
                                                            <i class="far fa-save" style="color: white;"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Quantity Input mediante Form:post -->
                                                    <!-- <form action="" method="post">
                                                        <input type="hidden" name="stock_qty" value="{{ $product->stock }}">
                                                        <div class="arrow-input">
                                                            <input type="text" id="prod-qty" class="form-control" 
                                                            name="input_qty" value="{{ $product->pivot->product_qty }}" autocomplete="off">
                                                            <div id="arrows">
                                                                <button class="arrow" name="arrow-up" value="{{ $product->id }}">▲</button>
                                                                <button class="arrow" name="arrow-down" value="{{ $product->id }}">▼</button>
                                                            </div>
                                                        </div>
                                                    </form> -->

                                                    <!-- Quantity Input mediante JAVASCRIPT (js/quantity.js) -->
                                                    <!-- <section class="quantity-container">
                                                        <div class="product-quantity">
                                                            <input data-min="1" data-max="0" type="text" name="quantity"
                                                                value="{{ $product->pivot->product_qty }}" readonly="true">
                                                            <div class="quantity-selectors-container">
                                                                <div class="quantity-selectors">
                                                                    <button type="button" class="increment-quantity"
                                                                        aria-label="Add one"
                                                                        data-direction="1"><span>&#43;</span></button>
                                                                    <button type="button" class="decrement-quantity"
                                                                        aria-label="Subtract one" data-direction="-1"
                                                                        disabled="disabled"><span>&#8722;</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section> -->

                                                </td>
                                                    <!-- <br> -->
                                                    <!-- <br> -->
                                                    <!-- <div> -->
                                                        <!-- Stock: {{ $product->stock }} uni -->
                                                    <!-- </div> -->
                                                <td>
                                                    <div class="price-wrap">
                                                        <var class="price"><?= $product->currency . number_format($product->price * $product->pivot->product_qty, 2, ',', '') ?>
                                                        </var>
                                                        <?php $subtot = $subtot + ($product->price * $product->pivot->product_qty) ?>
                                                        <!-- Hace la cuenta parcial -->
                                                        <?php $moneda = $product->currency ?>
                                                        <br>
                                                        <small class="text-muted">
                                                            <?= $product->currency . number_format($product->price, 2, ',', '') ?>
                                                            c/u</small>
                                                    </div> <!-- price-wrap .// -->
                                                </td>
                                                
                                                <td class="text-right d-none d-md-block">

                                                    <!-- Botón Agregar/Eliminar de Favoritos -->
                                                    <form
                                                        action="{{ asset('customer/favorites') }}"
                                                        method="post">
                                                        @csrf
                                                        @if ($is_favorite)
                                                        @method('patch')
                                                        @else
                                                        @method('post')
                                                        @endif

                                                        <!--<button class="btn btn-sm btn-primary" title="Ver" name="ver" value="{{ $product->id }}"> <i class="fas fa-eye"></i> </button>
                                                            <button class="btn btn-sm btn-warning" title="Mas Similares" name="mas" value="{{ $product->id }}"> <i class="fas fa-cart-plus" style="color: white;"></i> </button>
                                                            <button class="btn btn-sm btn-success" title="Guardar" name="guardar" value="{{ $product->id }}"> <i class="far fa-save" style="color: white;"></i> </button>
                                                            <button class="btn btn-sm btn-danger" title="Eliminar" name="eliminar" value="{{ $product->id }}"> <i class="fas fa-cart-arrow-down"></i> </button>-->
                                                        
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <button type="submit" id="cart-fav-button" name="add_del"
                                                            value="{{ $product->id }}"
                                                            title="Agregar/Eliminar de Mis Favoritos"
                                                            class="btn btn-sm btn-light">
                                                            <i class="fa fa-heart"
                                                                style="<?= $is_favorite ? 'color: crimson' : '' ?>"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Botón Eliminar del carrito -->
                                                    <form action="{{ url('customer/cart/add-del') }}"
                                                        method="post">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="cart_id" value="{{ $openCart->id }}">
                                                        <button class="btn btn-sm btn-danger"
                                                            title="Eliminar del Carrito" name="del_id"
                                                            value="{{ $product->id }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>

                                                </td>
                                                <!--<td><input type="checkbox" name="checkbox" id="" value="{{ $product['id'] }}"></td>-->
                                            </tr>
                                           
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    
                                </div> <!-- table-responsive.// -->

                                <div class="card-body border-top">
                                    <p class="icontext"><i class="icon text-success fa fa-truck"></i> Envío Gratis
                                        dentro de la semana 1-2</p>
                                </div> <!-- card-body.// -->

                            </div> <!-- card.// -->

                        </aside> <!-- col.// -->

                        <aside class="col-lg-3">

                            <!-- <div class="card mb-3">
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label>Tiene un Cupon?</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="" placeholder="Codigo">
                                                <span class="input-group-append">
                                                    <button class="btn btn-primary">Aplicar</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div> card-body.//
                            </div> card.// -->

                            <div class="card">
                                <div class="card-body">
                                    <dl class="dlist-align">
                                        <dt>Valor Total:</dt>
                                        <dd class="text-right"><?= $moneda . number_format($subtot, 2, ',', '') ?></dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Descuento:</dt>
                                        <dd class="text-right text-danger">- $0.00</dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Total (s/imp):</dt>
                                        <dd class="text-right text-dark b">
                                            <strong><?= $moneda . number_format($subtot, 2, ',', '') ?></strong></dd>
                                    </dl>
                                    <hr>
                                    <p class="text-center mb-3">
                                        <img src="{{ asset('img/payments.png') }}" height="26">
                                    </p>
                                    <form action="{{ url('customer/purchase') }}" method="post" id="buy-button">
                                        @csrf
                                        @method('post')
                                        @if ( $openCart )
                                        <button type="submit" name="cart_id" value="{{ $openCart ? $openCart->id:null }}" 
                                            class="btn btn-primary btn-block"
                                            style="{{ $openCart->products->isEmpty() ? 'background-color: gray; cursor: not-allowed' : null }}"
                                            <?= $openCart->products->isEmpty() ? 'disabled':null ?> > 
                                            @if($openCart->status === 'open') Realizar Compra @else Continuar Compra @endif
                                        </button>
                                        @else
                                        <div class="btn btn-primary btn-block" 
                                            style="background-color: gray; cursor: not-allowed" disabled>
                                            Realizar Compra
                                        </div>
                                        @endif
                                    </form>
                                    <a href="/" class="btn btn-warning btn-block">Continuar Navegando</a>
                                </div> <!-- card-body.// -->
                            </div> <!-- card.// -->

                        </aside> <!-- col.// -->
                    </div> <!-- row.// -->
                </article>
            </output>

            <hr>
            <!--<div id="erase-selected">
                <button class="btn btn-sm btn-danger" title="Eliminar Seleccionados" name="erase-selected" value=""> <i class="fas fa-cart-arrow-down"></i> </button>
            </div>-->
        </div>
    </div>

</div>

@endsection
