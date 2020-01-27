<aside class="col-md-3">
    <!--   SIDEBAR   -->
    <ul class="list-group">
        <a class="list-group-item <?= (Request::path() == 'customer/order/history') ? 'active' : null ?>" href="{{ url('customer/order/history') }}"> Mi historial de Órdenes </a>
        <a class="list-group-item <?= (Request::path() == 'customer/order/transaction') ? 'active' : null ?>" href="{{ url('customer/order/transaction') }}"> Pagos realizados </a>
        <a class="list-group-item <?= (Request::path() == 'customer/order/tracking') ? 'active' : null ?>" href="{{ url('customer/order/tracking') }}"
            onclick="event.preventDefault(); document.getElementById('tracking-form').submit();"> Tracking </a>
        <a class="list-group-item disabled" href="#"> Devoluciones </a>
        <a class="list-group-item disabled" href="#"> Configuración </a>
        <a class="list-group-item disabled" href="#"> Órdenes recibidas </a>

        <!-- El formulario 'tracking-form' se encuentra en los blades de 'orders' y 'transaction' -->
        
    </ul>
    <br>
    <div>
        <a class="btn btn-light btn-block" href="{{ route('logout') }}" 
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off"></i>
            <span class="text">Log out</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <!--   SIDEBAR .//END   -->
</aside>
