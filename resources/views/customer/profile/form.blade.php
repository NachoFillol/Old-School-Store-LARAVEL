<div class="datos-usuario">
    <form class="formulario" method="post" action="{{ url($url) }}" enctype="multipart/form-data">
        @csrf
        @method($method)

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputName">Nombre :</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('firstname') }}</p>

            </div>
            <div class="form-group col-md-6">
                <label for="inputLName">Apellido :</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('lastname') }}</p>

            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail">Email Principal :</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('email') }}</p>

            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail2">Email Alternativo :</label>
                <input type="email" name="email2" id="email2" class="form-control" value="{{ $user->email2 }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('email2') }}</p>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <p>
                    <label for="">Password :</label>
                    <input type="password" class="form-control" name="password" title="El password debe tener entre 4 y 10 caracteres de longitud, 
                donde cada carácter puede ser una letra mayúscula, minúscula o un dígito" value="{{ $user->password }}"
                        <?= $disabled ? 'readonly' : ''?>>
                </p>
            </div>
            <div class="form-group col-md-6">
                <p>
                    <label for="">Confirmar Password :</label>
                    <input type="password" class="form-control" name="password_confirmation"
                        title="El password debe tener entre 4 y 10 caracteres de longitud, 
                donde cada carácter puede ser una letra mayúscula, minúscula o un dígito" value="{{ $user->password }}"
                        <?= $disabled ? 'readonly' : ''?>>
                </p>
            </div>
            <p class="text-danger">{{ $errors->first('password') }}</p>     <!-- pattern="{{ $pattern }}" -->
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputUser">Teléfono :</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}"
                    <?= $disabled ? 'readonly' : ''?>>
            </div>
            <div class="form-group col-md-6">
                <label for="gender">Género :</label>
                <select name="gender" id="gender" class="form-control" <?= $disabled ? 'disabled' : ''?>>
                    <option <?= ($user->gender == 'Femenino' || old('gender') == 'Femenino') ? 'selected':null ?>
                        value="Femenino">Femenino</option>
                    <option <?= ($user->gender == 'Masculino' || old('gender') == 'Masculino') ? 'selected':null ?>
                        value="Masculino">Masculino</option>
                    <option <?= ($user->gender == 'Otro' || old('gender') == 'Otro') ? 'selected':null ?> value="Otro">
                        Otro</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="inputAddress">Direccion :</label>
            <input type="text" name="address" id="address" class="form-control"
                value="{{ $user->addresses[0]->address }}" <?= $disabled ? 'readonly' : ''?>>

            <p class="text-danger">{{ $errors->first('address') }}</p>

        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Ciudad :</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ $user->addresses[0]->city }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('city') }}</p>

            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Estado :</label>
                <select name="state" id="state" class="form-control" <?= $disabled ? 'disabled' : ''?>>
                <option value=""></option>
                    @foreach ($states as $state)
                    <option
                        <?= ($user->addresses->first()->state == $state->name || old('name') == $state->name ) ? 'selected':null ?>
                        value="{{ old('name', $state->name) }}">
                        {{ $state->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">C.P. :</label>
                <input type="text" name="zip" id="zip" class="form-control" value="{{ $user->addresses[0]->zip }}"
                    <?= $disabled ? 'readonly' : ''?>>

                <p class="text-danger">{{ $errors->first('zip') }}</p>

            </div>

            <div class="form-group col-md-6" id="avatar-file">
                <label for="">Cambiá tu Avatar :</label>
                <input type="file" name="avatar" accept=".jpg,.jpeg,.png," <?= $disabled ? 'disabled' : ''?>>
            </div>

        </div>

        <div class="boton-guardar">
            @if (!$disabled)
            <div class="form-group">
                <button name="editar" class="btn btn-sm btn-success" value="1">Guardar</button>
                <button name="cancelar" class="btn btn-sm btn-danger" value="1">Cancelar</button>
            </div>
            @else
            <!--  <input type="hidden" name="disabled" value="0"> -->
            <button name="disabled" class="btn btn-warning">Editar</button>
            @endif
            <br>
            <br>

            <div>
                <a class="" href="{{ route('logout') }}" title="Salir"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        </div>

        <!-- <div class="boton-guardar">
            <button type="submit" class="btn btn-outline-success">Guardar datos</button>
          </div> -->

    </form>
</div>
