@extends('website.layouts.website')
<!-- Index Template para mostrar TODOS los productos de Búsqueda Avanzada -->
@section('title')
Busqueda Avanzada de Producto
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

    <h4><mark>Búsqueda Avanzada</mark></h4>

    <div class="form-advanced-search">
        <form action="/search/advanced" method="get" id="advanced-search" class="formulario">
            <div class="form-group">
                <label for="search">Nombre :</label>
                <input type="text" class="form-control" placeholder="Búsqueda por nombre" name="word" required>
            </div>

            <div class="form-group">
                <label for="category">Categoría :</label>
                <select class="form-control" name="category" required>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="range-slider">
                <label for="price">Rango Precio :</label>
                <input class="range-slider__range" type="range" step="100" min="9" max="99999" name="price">
                <span class="range-slider__value">0</span>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="contenedor" id="advanced-search">
                        <button type="submit" class="btn btn-warning my-2 my-sm-0"
                            style="min-width: fit-content">Filtrar</button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="detailed" checked>
                        <label class="custom-control-label" for="customRadio1">Ver Detallado</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value="listed">
                        <label class="custom-control-label" for="customRadio2">Ver Listado</label>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
