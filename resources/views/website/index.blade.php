@extends('website.layouts.website')

@section('title')
    Home
@endsection

@section('header2')
@include('website.layouts.header2')
@endsection

@section('content')

<div class="content-wrap">

    <section class="destacados">
        <h2><mark>Productos Destacados</mark></h2>

        <div class="bd-example">
            <div class="row justify-content-center">
                <div class="col-12 col-md-11 col-lg-8 ">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        
                        <!-- Indicators -->
                        <ol class="carousel-indicators">

                            @foreach($products as $product)
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="<?= $loop->first ? 'active':null ?>"></li>
                            @endforeach

                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">

                            @foreach($products as $product)
                            <div class="carousel-item <?= $loop->first ? 'active':null ?>">
                                <img src="{{ asset($product->image) }}" width=500px class="d-block w-100" alt="{{ $product->name }}">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $product->name }}</h5>
                                </div>
                            </div>
                            @endforeach
                         
                        </div>

                        <!-- Controls -->
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stock">

        <h4> <mark> Nuestros Productos </mark> </h4>

        @foreach ($categories as $category)

            @if(count($category->products) != 0)
                <article class="stock-productos">
                    <h5> {{ $category->name }} </h5>
                    <a href="/category/{{$category->id}}"><img src="{{ asset($category->image) }}" alt=""></a>
                    <div>
                    <small>{{count($category->products)}}  Producto<?= (count($category->products) > 1 ) ? 's' : '' ?></small>
                    </div>
                </article>
            @endif
            
        @endforeach

    </section>


    <section class="frecuentes">

        <h4> <mark>Preguntas frecuentes</mark> </h4>

        <article class="frecuentes-tips">
        <div class="">
            <img src="img/tarjetas.png" alt="">
        </div>
        <h6>¿Como pago el producto?</h6>
        <p>Los productos los podes pagar con tarjetas de débito y crédito. Hay varios descuentos y promociones según el
            banco que tengas.</p>
        </article>

        <article class="frecuentes-tips">
        <div class="">
            <img src="img/envios.png" alt="">
        </div>
        <h6>¿Como enviamos el producto?</h6>
        <p>Después de comprar tu pedido, nos contactamos con vos para coordinar la entrega del producto. ¡Si vivis en
            Capital la entrega es en el día!</p>
        </article>

        <article class="frecuentes-tips">
        <div class="">
            <img src="img/seguridad.png" alt="">
        </div>
        <h6>¿Es seguro el sitio?</h6>
        <p>Mas de 200.000 ventas no avalan. Somos un sitio seguro, que dispone de productos originales y con garantía.
        </p>
        </article>

    </section>


    <section class="contacto">

        <div class="mensaje-newsletter">
        <p> ¡Queremos seguir conectados! Ingresa tu e-mail y recibí semanalmente en tu correo las mejores ofertas retro
            que tenemos para vos. </p>
        </div>
        <div class="correo">
        <form action="/" method="post" id="newsletter-form">
        @csrf
            <div class="input-group flex-nowrap">
            <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">@</span>
            </div>
            <input type="email" name="email" id="newsletter" class="form-control" placeholder="Email"
                aria-label="Newsletter" aria-describedby="addon-wrapping">
            <button class="btn btn-primary" type="submit" id="newsletter-btn">Enviar</button>
            </div>

            <p class="text-danger">{{ $errors->first('email') }}</p>
            
        </form>
        </div>

    </section>


    <section class="pie-pagina">

        <article>
        <h5>Servicios al cliente</h5>
        <ul>
            <li> <a href="#"> Centro de ayuda </a></li>
            <li> <a href="#"> Reembolso de dinero </a></li>
            <li> <a href="#"> Términos y Políticas </a></li>
            <li> <a href="#"> Disputa abierta </a></li>
        </ul>
        </article>

        <article>
        <h5>Sobre Nosotros</h5>
        <ul>
            <li> <a href="#"> Nuestra historia </a></li>
            <li> <a href="#"> Como comprar </a></li>
            <li> <a href="#"> Entregas y pagos </a></li>
            <li> <a href="#"> Ofertas semanales </a></li>
        </ul>
        </article>

        <article>
        <h5>Contactanos</h5>
        <ul>
            <li> <strong>Telefono:</strong> <a href="tel:+5412344321"> +54 1234-4321 </a></li>
            <li> <strong>Direccion:</strong> <a href="https://goo.gl/maps/5xoGKZzoD6cZ9G4e9" target="_blank"> Segurola y
                Habana, Buenos Aires. </a></li>
            <li> <strong>Email:</strong> <a href="mailto:info@oldschoolstore.com.ar?subject=Consulta">
                info@oldschoolstore.com.ar </a></li>
        </ul>
        </article>

    </section>
</div>
@endsection