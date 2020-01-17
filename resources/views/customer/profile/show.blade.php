@extends('website.layouts.website')

@section('title')
Mi Perfil
@endsection


@section('content')

<div class="container" id="perfilUs">

    <div class="content-wrap">

        <div class="usuario">

            <div class="usuario-perfil">

                <!-- Determina el Genero para la Bienvenida -->
                @if ( $user->gender == 'Femenino')
                <?php $mensaje = 'Bienvenida, '; ?>
                @if ( $user->gender == 'Masculino')
                <?php $mensaje = 'Bienvenido, '; ?>
                @else
                <?php $mensaje = 'Hola, '; ?>
                @endif
                @endif

                <!-- Determina el sexo para la Bienvenida. Si el usuario inicia session, mostrar el siguiente titulo -->
                <!-- iF el usuario inicio sesion -->
                <h3><?= $mensaje . $user->firstname . ' ' . $user->lastname ?></h3>
                <h5>Su Cod Usuario es el Nº {{ $user->code }} <small>
                        @if ($user->created_at != null) | Registro el {{$user->created_at}} @else null @endif
                    </small></h5>

                <!-- else -->
                <!-- Sino inicia, mostrar... -->
                <h3>Bienvenido/a, Usuario/a</h3>
                <!-- endif -->

                <h6>Ver Perfil</h6>

                <a href=""><img src="<?= $user->avatar ? asset('storage/'.$user->avatar) : asset('img/avatar/account-100.png') ?>"></a>
                <!-- <a href="#"><img src="img/usuariomario.png" alt=""></a> -->

            </div>

            <div class="barra-usuario">
                <nav>
                    <ul>
                        <li><a href="#">Mis Compras</a></li>
                        <li><a href="/customer/cart">Mi Carrito</a></li>
                        <li><a href="/customer/favorites">Mis Favoritos</a></li>
                    </ul>
                </nav>
            </div>

            @include('customer.profile.form', [
            'method' => 'post',
            'url' => '/customer/profile/' . $user->id . '/edit',
            'disabled' => 1])

        </div>
    </div>

</div>

@endsection
