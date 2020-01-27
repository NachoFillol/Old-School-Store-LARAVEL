<!-- Formulario tracking -->
<form id="tracking-form" action="{{ url('customer/order/tracking') }}" method="POST" style="display: none;">
    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
    @csrf
</form>
