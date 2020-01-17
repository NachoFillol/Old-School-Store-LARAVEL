@extends('website.layouts.website')

@if (! isset($results))
<!-- Index Template para mostrar TODOS los productos de Todas las Categorias (/categories) -->
@section('title')
Categoría Todas
@endsection

@section('header2')
@include('website.layouts.header2')
@endsection

@section('categorias')
<section class="categorias-inicio">
    <div class="ruta-categorias">
        <nav class="navBuscador">
            <ul>
                <li>Todos</li>
            </ul>
        </nav>
    </div>
</section>
@endsection

@section('content')

<div class="content-wrap">

    <h3><mark>Todos nuestros productos</mark></h3>

    <div style="text-align: center; font-style: italic; font-size: medium">Total {{$products->total()}}
        producto<?= (count($products) > 1 ) ? 's' : '' ?> | En esta página {{count($products)}}</div>

    <div class="detalleproductos">

        @foreach ($products as $product)
        <div class="card">
            <img src="{{ asset($product->image) }}" title="Envios a todo el pais" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="precio">{{$product->currency . $product->price}}</p>
                <p class="card-text">{{$product->description_general}}</p>
                <button type="button" name="button" class="btn btn-sm btn-primary my-2 my-sm-0"> 
                <a href="/product/{{ $product->id }}">Ver Producto</a></button>
            </div>
        </div>
        @endforeach

        <!-- VISTAS DE PAGINAS -->
        <div>{{$products->links()}}</div>

    </div>
</div>
<!-- </div> -->
@endsection

@else
<!-- Index Template para mostrar TODOS los productos de Todas las Categorias de Búsqueda -->
@section('title')
Resultados de búsqueda
@endsection

@section('header2')
@include('website.layouts.header2')
@endsection

@section('categorias')
<section class="categorias-inicio">
    <div class="ruta-categorias">
        <nav class="navBuscador">
            <ul>
                <li>Todos</li>
            </ul>
        </nav>
    </div>
</section>
@endsection

@section('content')

<div class="content-wrap">

    <h4><mark>{{$results->total()}} Categoría<?= ($results->total() > 1 || $results->total() == 0) ? 's' : '' ?>
            relacionada<?= ($results->total() > 1 || $results->total() == 0) ? 's' : '' ?> con la búsqueda
            "{{$search->search}}"</mark></h4>

    <div style="text-align: center; font-style: italic; font-size: medium">Se
        muestra<?= ($results->count() > 1 || $results->count() == 0) ? 'n' : '' ?> {{$results->count()}} en esta página
    </div>

    <div class="detalleproductos">

        @forelse ($results as $result)

        <div class="card" style="align-self: center">
            <h2>{{$result->name}}</h2><small>{{$result->products->count()}} Productos</small>
        </div>

        @foreach ($result->products as $product)
        <div class="card">
            <img src="{{ asset($product->image) }}" title="Envios a todo el pais" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="precio">{{$product->currency . $product->price}}</p>
                <p class="card-text">{{$product->description_general}}</p>
                <button type="button" name="button" class="btn btn-sm btn-primary my-2 my-sm-0"> <a
                        href="/product/{{ $product->id }}">Ver Producto</a></button>
            </div>
        </div>
        @endforeach

        @empty

        <h5>NO SE ENCONTRO PRODUCTO !!!</h5>

        @endforelse

        <!-- VISTAS DE PAGINAS -->
        <div>{{$results->links()}}</div>

    </div>
</div>

@endsection

@endif
