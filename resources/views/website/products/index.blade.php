@extends('website.layouts.website')
<!-- Index Template para mostrar TODOS los productos de Búsqueda -->
@section('title')
Busqueda por Producto
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

    <h4><mark>{{$results->total()}} Producto<?= ($results->total() > 1 || $results->total() == 0) ? 's' : '' ?>
            relacionado<?= ($results->total() > 1 || $results->total() == 0) ? 's' : '' ?> con la búsqueda
            "{{$search->word}}"</mark></h4>

    <div style="text-align: center; font-style: italic; font-size: medium">Se
        muestra<?= ($results->count() > 1 || $results->count() == 0) ? 'n' : '' ?> {{$results->count()}} en esta página
    </div>

    <div class="<?= (! $search->customRadio || $search->customRadio == 'detailed') ? 'detalleproductos' : 'listadoproductos' ?>">

        @if(! $search->customRadio || $search->customRadio == 'detailed')

            @forelse ($results as $product)
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
            @empty

            <h5>NO SE ENCONTRO PRODUCTO !!!</h5>

            @endforelse

        @elseif($search->customRadio == 'listed')

            <div class="list-group formulario">
                <h5>Listando {{$categories->find($search->category)->name}}</h5>
            <?php $count = 1 ?>
                @forelse ($results as $product)
                <div class="row">
                    <a href="{{ url('/product/'.$product->id) }}" style="display: inline-flex; align-items: center; justify-content: space-between; height: 80px"
                        class="list-group-item list-group-item-action 
                        list-group-item-<?= (($count%2) == 0) ? 'primary':'dark' ?>">  
                        <img src="{{ asset($product->image) }}" class="" style="width: 50px" alt="...">
                        {{ $product->name }} - {{ $product->currency . $product->price }} 
                        <small><i>clic para ver</i></small>
                    </a>
                </div>
            <?php $count++ ?>
            @empty

            <h5>NO SE ENCONTRO PRODUCTO !!!</h5>

            @endforelse
            </div>

        @endif


            <!-- VISTAS DE PAGINAS -->
            <div>{{$results->links()}}</div>

    </div>
</div>

@endsection
