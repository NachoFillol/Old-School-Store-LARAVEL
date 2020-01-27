<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Old School Store - @yield('title')</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap" rel="stylesheet">
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
    <!--<link rel="stylesheet" type="text/css" href="css/estilo.css">-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/estilo.css') }}">
</head>
<body>

<style>
.form-inline .col#radio-option {
    display: flex;
    flex-direction: column;
    font-size: smaller;
}
.form-inline .row#radio-option {
    flex-direction: row-reverse;
}
</style>

<div class="container">
  <header>
    <section class="barra-inicio">
      <!--<img src="img/logo.png" alt="Old School Store" id="logo">-->
      <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse show" id="navbarTogglerDemo01" style="">
        <div id="navbar-brand">
          <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.png') }}" alt="Old School Store" id="logo"></a>
        </div>
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            @guest
            <li class="nav-item"><a class="nav-link" href="{{ url('register') }}"><i class="fas fa-user"></i> Crear Cuenta</a></li>
            <li class="nav-item"><a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> Abrir Cuenta</a></li>
            @endif
            
            @auth
            <li class="nav-item"><a class="nav-link" href="{{ url('customer/order/history') }}" title="Mis Compras"><i class="fas fa-shopping-bag"></i> Mis Compras</a></li>
            <!-- Mi Carrito -->
            <li class="nav-item nav-link"><a href="{{ url('customer/cart') }}" class="widget-header" title="Mi Carrito">
            <div class="icon icon-sm rounded-circle border"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
            <span class="badge badge-pill badge-danger notify">
            {{ isset(auth()->user()->cartInProgress()->products) ? auth()->user()->cartInProgress()->products->sum('pivot.product_qty') : '0' }}
            </span></a></li>
            <!-- Favoritos -->
            <li class="nav-item nav-link"><a href="{{ url('customer/favorites') }}" class="widget-header" title="Mis Favoritos">
            <div class="icon icon-sm rounded-circle border"><i class="fa fa-heart" aria-hidden="true"></i></div>
            <span class="badge badge-pill badge-danger notify">
            {{ isset(Auth::user()->favorites) ? Auth::user()->favorites->count() : '0' }}
            </span></a></li>
            <!-- Mi Perfil -->
            <li class="nav-item"><a href="{{ url('customer/profile') }}"><img class="" src="{{ (Auth::user()->avatar) ? asset('/storage/'.Auth::user()->avatar) : asset('img/avatar/account-100.png') }}" alt="avatar" id="avatar" title="Mi Perfil"></a></li>
            <li class="nav-item">
              <div>
                <a class="nav-link" id="salir-home" href="{{ route('logout') }}" title="Salir"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i style="font-size: 1rem" class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
            @endif
          </ul>
        </div>
      </nav>
    </section>

    @yield('header2')

    @yield('categorias')

  </header>

  <div class="flash-message" style="height:44px">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
  </div> <!-- Funciona enviando el mesaje a traves del flash() a Session::class en el controlador. Necesita las query JAVA -->

  @yield('content')

  <footer>

    <div class="left-footer">
      <!-- Sin contenido, para dividir el footer en 3 -->
    </div>

    <div class="center-footer">

      <div class="social-area">
        <a class="facebook" href="https://www.facebook.com/" rel="nofollow" target="_blank"><i
            class="fab fa-facebook"></i></a>
        <a class="twitter" href="https://www.twitter.com/" rel="nofollow" target="_blank"><i
            class="fab fa-twitter"></i></a>
        <a class="instagram" href="https://www.instagram.com/" rel="nofollow" target="_blank"><i
            class="fab fa-instagram"></i></a>
      </div>

      <div class="derechos">
        <a href="/"> oldschoolstore.com.ar </a>
        <p>©2019 Todos los derechos reservados. </p>
      </div>

    </div>

    <div class="right-footer">
      <a href="/"> <i class="fas fa-home"></i> </a>
    </div>

  </footer>
</div>

    <!-- Scripts Java -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/range.js') }}"></script> <!-- Script para Range de busqueda avanzada -->
    <script src="{{ asset('js/quantity.js') }}"></script> <!-- Script para cantidad de items cart -->
    <script src="{{ asset('js/messages.js') }}"></script>
</body>

</html>