<form action="{{ url($url) }}" method="post">
@csrf
@method($method)

    <div class="form-group">
        <label for="user_type">Tipo :</label>
        <input type="text" class="form-control" placeholder="User Type" 
        name="type" style="width:25%" value="{{ old('type', $user_type->type) }}" required autofocus>
        <p class="text-danger">{{ $errors->first('user_type') }}</p>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Guardar</button>
    </div>
</form>
