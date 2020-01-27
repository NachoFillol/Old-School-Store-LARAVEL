@extends('admin.layouts.abm')

@section('title')
Old School Store - A/B/M Productos
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">

                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                                data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                        @endforeach
                    </div>
                    <!-- Funciona enviando el mesaje a traves del flash() a Session::class en el controlador. Necesita las query JAVA -->

                    <h1>Nuevo Producto</h1>
                </div>
                <img src="{{asset($product->image)}}" alt="Prod Img" style="width: 80px; padding: 10px">
            </div>

            <h5>Cod Producto Nº {{$code}}</h5>

            @include('admin.products.form', [
            'method' => 'post',
            'url' => '/admin/products'])

            <br>
            <a href="/">Ir a Home</a>

        </div>
    </div>
</div>

@endsection
