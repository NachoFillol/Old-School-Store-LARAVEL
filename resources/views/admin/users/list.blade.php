@extends('admin.layouts.abm')

@section('title')
    Old School Store - A/B/M Usuarios
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
        color: inherit;
    }

    button a:hover {
        color: unset;
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

            <h3>Usuarios Registrados ({{ $users->total() }})</h3>
            <div style="text-align: center; font-style: italic; font-size: medium">En esta página {{count($users)}}</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Cod</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email Principal</th>
                        <th>Dir</th>
                        <th>Rol</th>
                        <th>Avatar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->code }}</td>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->email1 }}</td>

                            <!-- Pide la direccion a traves del metodo addresses() en el Model de User (un array en posicion 0) -->
                            <td>@if (isset($user->addresses[0])) {{ $user->addresses[0]->address }} @else No tiene una dir. @endif</td>

                            <!-- Pide el tipo de Rol a traves del metodo rol() en el Model de User -->
                            <td>{{ $user->rol->type }}</td>

                            <td>
                                <img src="{{ asset('storage/'.$user->avatar) }}" style="border-radius: 50%; width: 25px;">
                            </td>
                            <td>
                                <div class="row">
                                <div>
                                    <button class="btn btn-sm btn-success" name="detalle" value="{{ $user->id }}"
                                        title="Detalle"><a href="{{ url('admin/users/'.$user->id) }}">
                                        <i class="fas fa-eye"></i></a></button>
                                </div>
                                <!-- <form action="{{ asset('users/'.$user->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="patch">
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $user->id }}"
                                        title="Editar"><i class="fas fa-edit"></i></button>
                                </form> -->
                                <div>
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $user->id }}"
                                        title="Editar"><a href="{{ url('admin/users/'.$user->id.'/edit') }}">
                                        <i class="fas fa-edit"></i></a></button>
                                </div>
                                <form action="{{ url('admin/users/'.$user->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <button class="btn btn-sm btn-danger" name="borrar" value="{{ $user->id }}"
                                        title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- VISTAS DE PAGINAS -->
            <div>{{$users->links()}}</div>

            <br>
            <a href="/">Ir a Home</a>
            
        </div>
    </div>
</div>

@endsection