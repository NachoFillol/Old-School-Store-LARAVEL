<form action="{{ url($url) }}" class="formulario" method="post">
    @csrf
    @method($method)

    <div class="form-group">
        <label for="inputEmail">Email :</label>
        <input type="email" id="email" class="form-control" placeholder="Email" 
        name="email" value="{{ old('email', $contact->email) }}" required autofocus>

        <p class="text-danger">{{ $errors->first('email') }}</p>

    </div>

    <div class="form-group">
        <label for="inputName">Nombre Completo :</label>
        <input type="text" id="fullname" class="form-control" placeholder="Nombre Completo" 
        name="fullname" value="{{ old('fullname', $contact->fullname) }}" required>

        <p class="text-danger">{{ $errors->first('fullname') }}</p>

    </div>

    <div class="form-group">
        <label for="inputOrder">Orden Nº :</label>
        <input type="text" id="order" class="form-control" placeholder="Orden Nº" 
        name="order" value="{{ old('order', $contact->order) }}" required>

        <p class="text-danger">{{ $errors->first('order') }}</p>

    </div>

    <div class="form-group">
        <label for="inputReason">Razón del Contacto ?</label>
        <select class="form-control" name="reason" id="reason" required>
            <option <?= ($contact->reason == 'orden' || old('reason') == 'reason') ? 'selected':null ?> value="orden">Mi Orden</option>
            <option <?= ($contact->reason == 'postOrden' || old('postOrden') == 'postOrden') ? 'selected':null ?> value="postOrden">Post Orden</option>
            <option <?= ($contact->reason == 'pago' || old('pago') == 'pago') ? 'selected':null ?> value="pago">Pagos</option>
            <option <?= ($contact->reason == 'devolver' || old('devolver') == 'devolver') ? 'selected':null ?> value="devolver">Devolver o Cancelar Orden</option>
            <option <?= ($contact->reason == 'daniado' || old('daniado') == 'daniado') ? 'selected':null ?> value="daniado">Producto Dañado</option>
        </select>

        <p class="text-danger">{{ $errors->first('reason') }}</p>

    </div>
    
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Tu Mensaje</span>
        </div>
        <textarea id="textarea" class="form-control" aria-label="With textarea" 
        name="textarea" required>{{ old('textarea', $contact->textarea) }}</textarea>

        <p class="text-danger">{{ $errors->first('textarea') }}</p>

    </div>

    <div class="contenedor" id="contact-form">
        <button type="submit" class="btn btn-warning my-2 my-sm-0" style="min-width: fit-content">Enviar</button>
    </div>

</form>
