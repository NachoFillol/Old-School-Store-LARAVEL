@extends('website.layouts.website')

@section('title')
Detalle Producto
@endsection

@section('header2')
@include('website.layouts.header2')
@endsection

@section('categorias')
<section class="categorias-inicio">
    <div class="ruta-categorias">
        <nav class="navBuscador">
            <ul>
                <li>Detalle <a href="/categories">Todas</a></li>
                <li>/</li>
                <li>Categoría <a href="/category/{{$product->category_id}}">{{ $product->category->name }}</a></li>
                <li>/</li>
                <li>Producto {{$product->name}}</li>
            </ul>
        </nav>
    </div>
</section>
@endsection

@section('content')

<div class="content-wrap" id="producto">

    <h3><mark>{{ $product->category->name }}</mark></h3>

    <section class="section-content bg padding-y-sm">

        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <main class="card">
                    <div class="row no-gutters">
                        <aside class="col-sm-6 border-right">
                            <!-- Columna Izquierda -->
                            <img style="width: 99%; {{ @(! $product->stock > 0) ? 'opacity:0.25' : 'null' }}"
                             src="{{ asset($product->image) }}">
                        </aside> <!-- Fin Columna Izquierda -->

                        <aside class="col-sm-6">
                            <!-- Columna Derecha -->

                            <article class="card-body">

                            <!-- Consulta si el producto existe como favorito, sino devuelve false -->
                            <?php $is_in_fav = $user ? $user->favorites->where('id', $product->id)->first() : false ?>
                            <!-- Consulta si el producto existe en el carrito, sino devuelve false -->
                            <?php $is_cart = $openCart ? $openCart->products->where('id', $product->id)->first() : false ?>

                                <div class="row" id="titulo-articulo">
                                    <!--<a href="#" class="title mt-2 h5">Titulo Producto</a>-->
                                    <div class="col-md-10">
                                        <h3>{{ $product->name }}</h3>
                                    </div>
                                    <div class="col-md-2">
                                        <form action="{{ url('customer/favorites') }}" method="post" id="add-favoritos">
                                        @csrf
                                        @if ($is_in_fav)
                                        @method('patch')
                                        @else
                                        @method('post')
                                        @endif
                                        <input type="hidden" name="user_id" value="{{ $user ? $user->id : null }}">
                                            <button type="submit" name="add_del" value="{{ $product->id }}"
                                                class="btn-link float-right" title="Agregar/Eliminar de Mis Favoritos"
                                                style="<?= $is_in_fav ? 'color: crimson' : '' ?>"> <i
                                                    class="fa fa-heart fa-2x"></i> </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <div class="price-wrap mr-4">
                                        <span class="price h5">{{$product->currency . $product->price}}</span>
                                        <span> / Aceptamos hasta 6 cuotas sin interes.</span>
                                    </div> <!-- price-dewrap // -->


                                    <div class="rating-wrap">
                                        <ul class="rating-stars" style="">
                                            <li style="width:80%" class="stars-active">
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                        <small class="label-rating text-muted">7/10</small>
                                    </div> <!-- rating-wrap.// -->
                                </div>


                                <dl>
                                    <dt>Descripcion</dt>
                                    <p>{{ $product->description_title }}</p>
                                </dl>
                                <dl class="row">

                                    <dt class="col-sm-3">Código</dt>
                                    <dd class="col-sm-9">{{ $product->code }}</dd>

                                    <dt class="col-sm-3">Modelo</dt>
                                    <dd class="col-sm-9">
                                        {{ $product->description_model . ' ' . $product->model }}
                                    </dd>

                                    <dt class="col-sm-3">Color</dt>
                                    <dd class="col-sm-9">{{ $product->colour }}</dd>

                                    <dt class="col-sm-3">Calidad</dt>
                                    <dd class="col-sm-9">
                                        {{ $product->quality . ', ' . $product->description_quality }}
                                    </dd>
                                </dl>
                                <div class="rating-wrap">
                                    <div class="label-rating">10 productos ya fueron vendidos!</div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <dl class="dlist-inline">
                                            <dt>En Stock </dt>
                                            <dd>
                                                <span>{{ $product->stock }}</span>
                                            </dd>
                                        </dl>
                                    </div>

                                    <div class="col-sm-9">
                                        <dl class="dlist-inline">
                                            <dt>¿Te enviamos el producto a tu domicilio? </dt>
                                            <dd>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inlineRadioOptions"
                                                        id="inlineRadio2" value="option2" type="radio">
                                                    <span class="form-check-label">SI</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" name="inlineRadioOptions"
                                                        id="inlineRadio2" value="option2" type="radio">
                                                    <span class="form-check-label">NO, voy al local.</span>
                                                </label>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>

                                <section id="cart-form">
                                    <form class="form-inline" action="{{ url('customer/cart/add-del') }}" method="post"
                                        id="add-carrito">
                                        @csrf
                                        @if (! $is_cart)
                                        @method('post')
                                        @else
                                        @method('patch')
                                        @endif
                                        <div class="form-group mx-sm-3 mb-2">
                                            <dl>
                                                <dt>Cantidad </dt>
                                                <dd id="input-qty">
                                                    <input type="number" name="prod_qty" class="form-control" rows="1"
                                                        min="0" max="{{ $product->stock }}" value="1"
                                                        maxlenght="<?= strlen($product->stock) ?>" style="">
                                                    <input type="hidden" name="user_id" value="{{ $user ? $user->id : null }}">
                                                    <input type="hidden" name="cart_id" value="<?= $openCart ? $openCart->id:null ?>">
                                                </dd>
                                            </dl>
                                        </div>
                                        <section id="cart-buttons">
                                            @if($is_cart && $product->stock > 0)
                                            <a name="add_id" id="cart-btn" class="btn btn-primary" 
                                                style="opacity: 0.65; cursor: not-allowed; color: #fff" disabled>
                                                <span class="text">Agregado al Carrito</span> <i class="fas fa-shopping-cart"></i>
                                            </a>
                                            @elseif ($product->stock > 0)
                                            <button type="submit" name="add_id" value="{{ $product->id }}" id="cart-btn" 
                                                class="btn btn-primary">
                                                <span class="text">Agregar al Carrito</span> <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            @else
                                            <div id="cart-btn" class="btn btn-primary" 
                                                style="background-color: gray; cursor: not-allowed" disabled>
                                                <span class="text">No Disponible</span> 
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            @endif
                                            <button type="submit" name="del_id" value="{{ $product->id }}" 
                                                title="Eliminar del Carrito" id="cart-btn"
                                                class="btn btn-danger <?= $is_cart ? null : 'isDisabled' ?>">
                                                <span class="text"></span> <i class="fas fa-cart-arrow-down"></i>
                                            </button>
                                        </section>
                                    </form>
                                    
                                    <!-- MUESTRA LOS MENSAJES DE ERROR o ADVERTENCIA !!! -->
                                    <!-- <p class="text-danger" style="font-style: italic; font-weight: bold">
                                        <= session('message') ?? '' ?></p> -->
                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                            @if(Session::has('alert-' . $msg))
                                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                            @endif
                                        @endforeach
                                </section>

                                <hr>

                                @if($product->stock > 0)
                                <!-- <a href="#" class="btn btn-primary mb-2" style="width: 100%; border-width: 0">Comprar</a> -->
                                @endif

                            </article>
                        </aside> <!-- Fin Columna Derecha -->
                    </div>
                </main>

                <!-- DETALLE DEL PRODUCTO -->
                <article class="card mt-3">
                    <div class="card-body">
                        @if ( $product->description_detail != '')
                        <h4>{{ 'Detalles de ' . $product->name }}</h4>
                        <p>{{ $product->description_detail }}</p>
                        @else
                        <h4>Sin Detalle</h4>
                        @endif
                    </div>
                </article>

            </div>
        </div>

    </section>
</div>

@endsection
