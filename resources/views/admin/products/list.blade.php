@extends('admin.layouts.abm')

@section('title')
    Old School Store - A/B/M Productos
@endsection

@section('content')

<style>
    .container {
        padding: 20px;
    }

    .table.table.table-hover {
        font-size: 0.75rem;
    }

    button.btn.btn-sm {
        width: 30px;
        height: 25;
        margin: 2px;
    }

    form {
        margin-block-end: 0em;
    }

    button a {
        color: white;
    }

    button a:hover {
        color: white;
        text-decoration: unset;
    }

</style>

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
            </div> <!-- Funciona enviando el mesaje a traves del flash() a Session::class en el controlador. Necesita las query JAVA -->

            <h3>Articulos Registrados ({{ $products->total() }})</h3>
            <div style="text-align: center; font-style: italic; font-size: medium">En esta página {{count($products)}}</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Cod</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Calidad</th>
                        <th>Estado</th>
                        <th>Imagen</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>

                        <!-- Pide el nombre de la categoria a traves del metodo category() en el Model de Product -->
                        <td>{{ $product->category->name }}</td>

                        <td>{{ $product->currency . $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->quality }}</td>
                        <td><?= ($product->status == 1) ? 'Activo':'Inactivo' ?></td>
                        <td>
                            <img src="{{ asset($product->image) }}" style="width: 25px;">
                        </td>
                        <td>
                            <div class="row">
                                <div>
                                    <button class="btn btn-sm btn-success" name="detalle" value="{{ $product->id }}"
                                        title="Detalle"><a href="{{ url('/product/'.$product->id) }}">
                                        <i class="fas fa-eye"></i></a></button>
                                </div>
                                <!-- <form action="{{ asset('products/'.$product->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="patch">
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $product->id }}"
                                        title="Editar"><i class="fas fa-edit"></i></button>
                                </form> -->
                                <div>
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $product->id }}"
                                        title="Editar"><a href="{{ url('admin/products/'.$product->id.'/edit') }}">
                                        <i class="fas fa-edit"></i></a></button>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-warning" name="confirmar" value="{{ $product->id }}"
                                        title="Confirmar"><a href="{{ url('admin/products/'.$product->id.'/del') }}">
                                        <i class="fas fa-exclamation-triangle"></i></a></button>
                                </div>
                                <form action="{{ url('admin/products/'.$product->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <button class="btn btn-sm btn-danger" name="borrar" value="{{ $product->id }}"
                                        title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- VISTAS DE PAGINAS -->
            <div>{{$products->links()}}</div>

            <br>
            <a href="/">Ir a Home</a>

        </div>
    </div>
</div>

@endsection
