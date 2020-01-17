<form action="{{ url($url) }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- DIRECTIVA OBLIGATORIA !!! Es un campo oculto para comprobacion -->

    @method($method)

    <h5 style="text-align: left">Datos - Detalle General de Producto</h5>

    <div class="form-row">

        <div class="form-group col-md-3">
            <label for="name">Título :</label>
            <input type="text" class="form-control" placeholder="Título" name="name" 
            value="{{ old('name', $product->name) }}" required autofocus 
            <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('name') }}</p>

        </div>

        <div class="form-group col-md-3">
            <label for="category">Categoría :</label>
            <select name="category_id" id="categoria" class="form-control" required <?= ($method === 'delete') ? 'disabled' : null ?> >
                @if (! old('category_id'))  <!-- VERIFICAR SI EXISTE VALOR OLD() -->
                    @foreach ($categories as $category)
                    <option <?= ($product->category_id == $category->id) ? 'selected':null ?> 
                    value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                @else
                    @foreach ($categories as $category)
                    <option <?= (old('category_id') == $category->id) ? 'selected':null ?> 
                    value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                @endif
            </select>

            <p class="text-danger">{{ $errors->first('category_id') }}</p>

        </div>

        <div class="form-group col-md-3">
            <label for="quality">Calidad :</label>
            <select name="quality" id="calidad" class="form-control" required <?= ($method === 'delete') ? 'disabled' : null ?> >
                <option <?= ($product->quality == 'Nuevo' || old('quality') == 'Nuevo') ? 'selected':null ?> value="Nuevo">Nuevo</option>
                <option <?= ($product->quality == 'Usado' || old('quality') == 'Usado') ? 'selected':null ?> value="Usado">Usado</option>
            </select>

            <p class="text-danger">{{ $errors->first('quality') }}</p>

        </div>

        <div class="form-group col-md-2">
            <label for="status">Estado :</label>
            <select name="status" id="estado" class="form-control" required <?= ($method === 'delete') ? 'disabled' : null ?> >
                <option <?= ($product->status == '1' || old('status') == '1') ? 'selected':null ?> value="1">Activo</option>
                <option <?= ($product->status == '0' || old('status') == '0') ? 'selected':null ?>  value="0">Inactivo</option>
            </select>

            <p class="text-danger">{{ $errors->first('status') }}</p>

        </div>

        <div class="form-group col-md-1">
            <label for="stock">Stock :</label>
            <input type="number" step="1" class="form-control" placeholder="XX" name="stock" 
            value="{{ old('stock', $product->stock) }}" <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('stock') }}</p>

        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="model">Modelo :</label>
            <input type="text" class="form-control" placeholder="Modelo" name="model" 
            value="{{ old('model', $product->model) }}" required <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('model') }}</p>

        </div>

        <div class="form-group col-md-2">
            <label for="colour">Color :</label>
            <input type="text" class="form-control" placeholder="Color" name="colour" 
            value="{{ old('colour', $product->colour) }}" required <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('colour') }}</p>

        </div>

        <div class="form-group col-md-2">
            <label for="discount_id">Id Dto :</label>
            <select name="discount_id" id="descuento" class="form-control" <?= ($method === 'delete') ? 'disabled' : null ?> >
                <option value="">Sin Dto.</option>
                @if (! old('discount_id'))  <!-- VERIFICAR SI EXISTE VALOR OLD() -->
                    @foreach ($discounts as $discount)
                    <option <?= ($product->discount_id == $discount->id) ? 'selected':null ?> 
                    value="{{ $discount->id }}">{{ $discount->code }}</option>
                    @endforeach
                @else
                    @foreach ($discounts as $discount)
                    <option <?= (old('discount_id') == $discount->id) ? 'selected':null ?> 
                    value="{{ $discount->id }}">{{ $discount->code }}</option>
                    @endforeach
                @endif
            </select>

            <p class="text-danger">{{ $errors->first('discount_id') }}</p>

        </div>

        <div class="form-group col-md-1">
            <label for="currency">Moneda :</label>
            <select name="currency" id="moneda" class="form-control" required <?= ($method === 'delete') ? 'disabled' : null ?> >
                <option <?= ($product->currency == '$' || old('currency') == '$') ? 'selected':null ?> value="$">$</option>
                <option <?= ($product->currency == 'U$S' || old('currency') == 'U$S') ? 'selected':null ?> value="U$S">U$S</option>
            </select>

            <p class="text-danger">{{ $errors->first('currency') }}</p>

        </div>

        <div class="form-group col-md-2">
            <label for="price">Precio :</label>
            <input type="text" class="form-control" placeholder="Precio" name="price" 
            value="{{ old('price', $product->price) }}" required 
            <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('price') }}</p>

        </div>

        <div class="form-group col-md-3">
            <label for="image">Imagen :</label>
            <input type="file" name="image" accept="image/*" class="" id="imagen"
                aria-describedby="inputGroupFileAddon01" <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('image') }}</p>

        </div>

    </div>

    <div class="form-group">
        <label for="descripcion">Descripción Detallada :</label>
        <textarea type="text" rows="8" cols="" class="form-control" placeholder="Descripcion" 
        name="description_detail" <?= ($method === 'delete') ? 'disabled' : null ?> >
        {{ old('description_detail', $product->description_detail) }}</textarea>

        <p class="text-danger">{{ $errors->first('descripcion_detail') }}</p>

    </div>

    <h5 style="text-align: left">Datos - Página Detalle Productos</h5>

    <div class="form-group">
        <label for="descripcion">Descripción General :</label>
        <input type="text" class="form-control" placeholder="Descripcion" 
        name="description_general" value="{{ old('description_general', $product->description_general) }}"
        <?= ($method === 'delete') ? 'disabled' : null ?> >

        <p class="text-danger">{{ $errors->first('descripcion_general') }}</p>

    </div>

    <h5 style="text-align: left">Datos - Página Articulo</h5>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="descripcion">Descripción Modelo :</label>
            <input type="text" class="form-control" placeholder="Descripcion" 
            name="description_model" value="{{ old('description_model', $product->description_model) }}"
            <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('descripcion_model') }}</p>

        </div>

        <div class="form-group col-md-6">
            <label for="descripcion">Descripción Calidad :</label>
            <input type="text" class="form-control" placeholder="Descripcion" 
            name="description_quality" value="{{ old('description_quality', $product->description_quality) }}"
            <?= ($method === 'delete') ? 'disabled' : null ?> >

            <p class="text-danger">{{ $errors->first('descripcion_quality') }}</p>

        </div>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción Venta :</label>
        <input type="text" class="form-control" placeholder="Descripcion" 
        name="description_title" value="{{ old('description_title', $product->description_title) }}"
        <?= ($method === 'delete') ? 'disabled' : null ?> >

        <p class="text-danger">{{ $errors->first('descripcion_title') }}</p>

    </div>

    <hr>

    <div class="form-group">
        <input type="hidden" name="code" value="{{ old('code', $code) }} ">
        @if ($method === 'patch' || $method === 'post')
        <button type="submit" class="btn btn-success">Guardar</button>
        @elseif ($method === 'delete')
        <button type="submit" class="btn btn-danger">Eliminar</button>
        @endif
    </div>
</form>
