@extends('website.layouts.website')

@section('title')
Categoría {{$category->name}}
@endsection

@section('header2')
@include('website.layouts.header2')
@endsection

@section('categorias')
<section class="categorias-inicio">
    <div class="ruta-categorias">
        <nav class="navBuscador">
            <ul>
                <li>Detalle <a href="/category/all">Todas</a></li>
                <li>/</li>
                <li>Categoría {{$category->name}}</li>
            </ul>
        </nav>
    </div>
</section>
@endsection

@section('content')

<div class="content-wrap">

    <h3><mark>{{$category->name}}</mark></h3>

    <div style="text-align: center; font-style: italic; font-size: medium">Total {{$products->total()}}
        producto<?= (count($products) > 1 ) ? 's' : '' ?> | En esta página {{count($products)}}</div>
    <!-- <div style="text-align: center; font-style: italic; font-size: medium">Total {{count($category->products)}} producto<= (count($category->products) > 1 ) ? 's' : '' ?></div> -->

    <div class="detalleproductos">

        @foreach ($products as $product)
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
        <!-- va con: $category = Category::findOrFail($id); en el controlador -->

        <!-- VISTAS DE PAGINAS -->
        <div>{{$products->links()}}</div>

    </div>
</div>

@endsection
