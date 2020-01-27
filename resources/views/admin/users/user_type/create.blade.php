@extends('admin.layouts.abm')

@section('title')
Nuevo Rol
@endsection

@section('content')
<div class="container">
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

            <h1>User Type Create</h1>

            @include('admin.users.user_type.form', [
            'method' => 'post',
            'url' => '/admin/user_type'])

            <br>
            <a href="/">Ir a Home</a>

        </div>
    </div>
</div>
@endsection
