@extends('website.layouts.website')

@section('title')
Registro
@endsection

@section('content')

<div class="content-wrap">

    <div class="form-register">
        <form action="{{ route('register') }}" class="formulario" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="firstname">Nombre :</label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}" id="fname"
                        class="form-control @error('firstname') is-invalid @enderror" autocomplete="Nombre" required autofocus>

                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="lastname">Apellido :</label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" id="lname"
                        class="form-control @error('lastname') is-invalid @enderror" autocomplete="Apellido" required>

                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email Principal :</label>
                    <input type="email" name="email" value="{{ old('email') }}" id="email"
                        class="form-control @error('email') is-invalid @enderror" autocomplete="Email" required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="email2">Email Alternativo :</label>
                    <input type="email" name="email2" value="{{ old('email2') }}" id="email2"
                        class="form-control @error('email2') is-invalid @enderror" autocomplete="Email Alternativo">

                        @error('email2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                </div>

                <div class="form-group col-md-6">
                        <label for="inputPassword">Contraseña :</label>
                        <input type="password" name="password" id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        autocomplete="Password" required>
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="Password_Confirm">Confirmacion Contraseña :</label>
                    <input id="password-confirm" type="password" class="form-control" 
                    name="password_confirmation" required autocomplete="Confirmar Contraseña">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="phone">Teléfono :</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" id="phone"
                        class="form-control @error('phone') is-invalid @enderror">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group col-md-6">
                    <label for="gender">Género :</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option <?= old('gender') == 'Femenino' ? 'selected':null ?>
                            value="Femenino">Femenino</option>
                        <option <?= old('gender') == 'Masculino' ? 'selected':null ?>
                            value="Masculino">Masculino</option>
                        <option <?= old('gender') == 'Otro' ? 'selected':null ?>
                            value="Otro">Otro</option>
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label for="Address1">Direccion :</label>
                <input type="text" name="address" value="{{ old('address') }}" id="address"
                    class="form-control @error('address') is-invalid @enderror" autocomplete="1234 Main St">

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="City">Ciudad :</label>
                    <input type="text" name="city" value="{{ old('city') }}" id="city"
                        class="form-control @error('city') is-invalid @enderror">

                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                
                <div class="form-group col-md-4">
                    <label for="state">Estado :</label>
                    <select name="state" id="state" class="form-control">
                        <option value="" <?= old('state') ? null:'selected' ?> ></option>
                        @foreach ($states as $state)
                        <option
                            <?= (old('state') == $state->name) ? 'selected':null ?>
                            value="{{ old('state', $state->name) }}">
                            {{ $state->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="Zip">C.P. :</label>
                    <input type="text" name="zip" value="{{ old('zip') }}" id="zip" 
                    class="form-control @error('zip') is-invalid @enderror">

                    @error('zip')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

            </div>

            <div class="form-group col-md-6" id="avatar-file">
                <label for="">Subi tu Avatar :</label>
                <input type="file" name="avatar" accept="image/*">
            </div>

            <div class="form-check">
                <label class="form-check-label" for="gridCheck">
                    <input class="form-check-input" type="checkbox" name="accept" id="accept" value="1" required>
                    <i>Acepto las condiciones y términos</i>
                </label>
            </div>
            <br>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>

            <!-- <button type="submit" class="btn btn-primary">Enviar</button> -->
            <!-- <div class="register-boton">
                <input type="image" src="img/img.register/PRESSSTAR.png" alt="press start" class="form-btn">
            </div> -->

        </form>
    </div>
</div>

@endsection
