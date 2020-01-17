<form action="{{ url($url) }}" method="post" role="form">
@csrf
@method($method)

    <div class="form-group">
        <label for="address">Direccion </label>
        <input type="text" class="form-control"  placeholder="Calle Nº..."
        name="address" value="{{ old('address', $shipment->address) }}">

        <p class="text-danger">{{ $errors->first('address') }}</p>

    </div> <!-- form-group.// -->

    <!--<div class="form-group">
        <label for="address2">Direccion 2</label>
        <input type="text" class="form-control" name="address2" placeholder="entre calles...">
    </div>  form-group.// -->

    <div class="form-row">
        <!--<div class="form-group col-md-6">
            <label for="phone1">Teléfono Contacto</label>
            <input type="tel" class="form-control" name="phone1" placeholder="+541176541230">
        </div>  form-group.// -->

        <!--<div class="form-group col-md-6">
            <label for="phone2">Teléfono Alternativo</label>
            <input type="tel" class="form-control" name="phone2" placeholder="+541176541230">
        </div>  form-group.// -->

        <div class="form-group col-md-6">
            <label for="city">Ciudad</label>
            <input type="text" class="form-control" placeholder="ciudad"
            name="city" value="{{ old('city', $shipment->city) }}">

            <p class="text-danger">{{ $errors->first('city') }}</p>

        </div> <!-- form-group.// -->

        <div class="form-group col-md-4">
            <label for="state">Estado</label>
            <select id="state" class="form-control" name="state" value="{{ old('state', $shipment->state) }}">
                @foreach ($states as $state)
                    <option <?= ($state->name == '{{ $state->name }}' || old('name') == '{{ $state->name }}') ? 'selected':null ?>
                        value="{{ old('name', $state->name) }}">
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>

            <p class="text-danger">{{ $errors->first('state') }}</p>

        </div> <!-- form-group.// -->

        <div class="form-group col-md-2">
            <label for="zip">C.P.</label>
            <input type="text" class="form-control" placeholder="cod. pos."
            name="zip" value="{{ old('zip', $shipment->zip) }}">

            <p class="text-danger">{{ $errors->first('zip') }}</p>

        </div> <!-- form-group.// -->
    </div>

    <label class="custom-control custom-checkbox">
        <input type="checkbox" name="checkbox" class="custom-control-input" checked>
        <div class="custom-control-label">Usar Datos de Mi Cuenta para el Envio
        </div>
    </label>

    <!--<label class="custom-control custom-checkbox">
        <input type="checkbox" name="checkbox" class="custom-control-input">
        <div class="custom-control-label">Retiro en persona
        </div>
    </label>-->

    <!-- <input type="hidden" name="cart_id" value="{{ $openCart->id }}"> -->
    <button type="submit" name="user_id" value="{{ $user->id }}" 
    class="subscribe btn btn-primary btn-block"> Confirmar </button>
</form>
