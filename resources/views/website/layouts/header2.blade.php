<section class="categorias-inicio">
    <nav class="navBuscador">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                @if(Request::path() == '/')
                <a class="nav-link active" href="/">Home</a>
                @else
                <a class="nav-link" href="/">Home</a>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">Categorias</a>
                <div class="dropdown-menu">
                    @foreach ($categories as $category)
                    @if (count($category->products) != 0)
                    <a class="dropdown-item" href="/category/{{$category->id}}">{{$category->name}}</a>
                    @endif
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/categories">Todas</a>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Lo mas vendido</a></li>
            <li class="nav-item"><a class="nav-link" href="/contact">Contactanos</a></li>
        </ul>
    </nav>
    <nav class="navbar">
        <div class="row" id="search-bar">
            <form class="search-form" action="/search" method="get">
                <input id="search-input" class="form-control mr-sm-2" name="word" type="search"
                    placeholder="Búsqueda por nombre" aria-label="Search" required>
                <button type="submit" id="search-button" class="btn btn-sm btn-primary my-2 my-sm-0">Buscar</button>
            </form>
            <a href="/advanced" id="search-button" class="btn btn-sm btn-primary my-2 my-sm-0">Búsqueda Avanzada</a>
        </div>
    </nav>
</section>
