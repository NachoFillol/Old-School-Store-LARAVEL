@extends('website.layouts.website')

@section('title')
Mis Favoritos
@endsection


@section('content')

<div id="mis-favoritos">
    <div class="row">
        <div class="col">
            <h4>Mis Favoritos <i class="fa fa-heart" aria-hidden="true"></i></h4>
            <h6>Cod Usuario ({{ $user->code }}) | Cantidad Items
                ({{ count($user->favorites) }})</h6>

            <output>
                <!-- =========================  COMPONENT WISHLIST ========================= -->
                <article class="card">
                    <header class="card-header"> Mis Favoritos </header>
                    <div class="card-body">
                        <div class="row">

                            @if ( count($user->favorites) != 0 )
                            @foreach($user->favorites as $favorite)

                            <!-- Consulta si el producto existe en el carrito, sino devuelve false -->
                            <?php $is_cart = $openCart ? $openCart->products->where('id', $favorite->id)->first():false ?>

                            <div class="col-md-4">
                                <figure class="itemside mb-4">
                                    <div class="aside"><img style="width: 140px; height: 140px"
                                            src="{{ asset($favorite->image) }}" class="border img-md"></div>
                                    <figcaption class="info">
                                        <a href="/product/{{$favorite->id}}" class="title">{{ $favorite->name }}</a>
                                        <p class="price mb-2">{{ $favorite->currency.$favorite->price }}</p>
                                        
                                        <form action="{{ asset('customer/cart/add-del') }}"
                                            method="post">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" name="prod_qty" value="1">
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="cart_id" value="<?= $openCart ? $openCart->id:null ?>">
                                            <button type="submit" name="add_id" value="{{ $favorite->id }}" id="cart-btn"
                                                class="btn btn-primary btn-sm" <?= $is_cart ? 'disabled':null ?>> 
                                                <span class="text">Agregar al Carrito</span>
                                                <i class="fas fa-shopping-cart"></i> </button>
                                        </form>

                                        <form action="{{ asset('customer/favorites/product/'. $favorite->id) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                title="Eliminar de Favoritos" name="del_id"
                                                value="{{ $favorite->id }}" data-original-title="Remove from wishlist">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>

                                    </figcaption>
                                </figure>
                            </div> <!-- col.// -->

                            @endforeach
                            @endif

                        </div> <!-- row .//  -->
                    </div> <!-- card-body.// -->
                </article>
                <!-- =========================  COMPONENT WISHLIST END.// ========================= -->
            </output>

        </div>
    </div>
</div>

@endsection
