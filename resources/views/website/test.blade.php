Listado Categorias:
<br>
@foreach ($exist_cat as $categ)
{{$categ->name}}
<br>
@endforeach
<br>
<br>
Categorias y Cantidades:
<br>
@foreach ($qty_prod as $prod)
Nombre: {{$prod->name}} / Cant: {{$prod->items}}
<br>
@endforeach
<hr>
@foreach ($categories as $category)
@if (! $category->product_qty == 0)
Cat {{$category->name}} sin productos
<br>
@else
Cat {{$category->name}} con productos
<br>
@endif
@endforeach