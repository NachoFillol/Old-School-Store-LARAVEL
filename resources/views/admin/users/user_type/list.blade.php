@extends('admin.layouts.abm')

@section('title')
    Old School Store - A/B/M Rol de Usuario
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

            <h3>Roles de Usuarios Registrados ({{ count($user_type) }})</h3>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($user_type as $role)
                        <tr>
                            <td>{{ $role->id }}</td>

                            <!-- Pide el tipo de Rol a traves del metodo rol() en el Model de User -->
                            <td>{{ $role->type }}</td>

                            <td>
                                <div class="row">
                                <!-- <div>
                                    <button class="btn btn-sm btn-success" name="detalle" value="{{ $role->id }}"
                                        title="Detalle"><a href="{{ asset('user/'.$role->id) }}">
                                        <i class="fas fa-eye"></i></a></button>
                                </div> -->
                                <!-- <form action="{{ asset('users/'.$role->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="patch">
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $role->id }}"
                                        title="Editar"><i class="fas fa-edit"></i></button>
                                </form> -->
                                <!-- <div>
                                    <button class="btn btn-sm btn-primary" name="editar" value="{{ $role->id }}"
                                        title="Editar"><a href="{{ asset('users/'.$role->id.'/edit') }}">
                                        <i class="fas fa-edit"></i></a></button>
                                </div> -->
                                <form action="{{ url('admin/user_type/'.$role->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <button class="btn btn-sm btn-danger" name="borrar" value="{{ $role->id }}"
                                        title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <a href="/">Ir a Home</a>
            
        </div>
    </div>
</div>

@endsection