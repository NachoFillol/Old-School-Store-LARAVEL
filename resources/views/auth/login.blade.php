@extends('website.layouts.website')

@section('title')
Login
@endsection

@section('content')

<!-- <div class="container" id="login"> -->

<div class="content-wrap">

    <div class="form-login">
        <form action="{{ route('login') }}" class="formulario" method="post">
            @csrf

            <p class="text-danger"><?= $error ?? '' ?></p>

            <div class="form-group">
                <label for="email">Email :</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" autocomplete="email" required autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="password">Contraseña :</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" autocomplete="current-password" required>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Recordame') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                    @endif
                </div>
            </div>

            <!-- <div class="form-group">
                <button type="submit" class="btn btn-warning my-2 my-sm-0">Log in</button>
                <a class="olvido-pass" href="#">Olvidaste tu contraseña?</a>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label" for="gridCheck">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" checked>
                        <i>Recordarme</i>
                    </label>
                </div>
            </div> -->

        </form>
    </div>
</div>

<!-- </div> -->

@endsection
