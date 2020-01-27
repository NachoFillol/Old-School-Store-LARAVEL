<form action="{{ url($url) }}" method="post" role="form">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="owner">Nombre en la Tarjeta</label>
        <input type="text" class="form-control" placeholder="Ex. John Smith"
        name="owner" value="{{ old('owner', $paymentcard->owner) }}" required>

        <p class="text-danger">{{ $errors->first('owner') }}</p>

    </div> <!-- form-group.// -->

    <div class="form-group">
        <label for="cardNumber">Numero de Tarjeta</label>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX" maxlength="16"
            name="number" value="{{ old('number', $paymentcard->number) }}" required>
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fab fa-cc-visa"></i> &nbsp; <i class="fab fa-cc-amex"></i> &nbsp;
                    <i class="fab fa-cc-mastercard"></i>
                </span>
            </div>

            <p class="text-danger">{{ $errors->first('number') }}</p>

        </div> <!-- input-group.// -->
    </div> <!-- form-group.// -->

    <div class="row">
        <div class="col-md flex-grow-0" id="expiration">
            <div class="form-group">
                <label><span class="hidden-xs">Vencimiento</span> </label>
                <div class="form-inline" style="min-width: 250px">
                    <select class="form-control" style="width:130px" 
                    name="month_expiration" value="{{ old('month_expiration', $paymentcard->month_expiration) }}" required>
                        <option value="01">01 - Ene</option>
                        <option value="02">02 - Feb</option>
                        <option value="03">03 - Mar</option>
                        <option value="04">04 - Abr</option>
                        <option value="05">05 - May</option>
                        <option value="06">06 - Jun</option>
                        <option value="07">07 - Jul</option>
                        <option value="08">08 - Ago</option>
                        <option value="09">09 - Sep</option>
                        <option value="10">10 - Oct</option>
                        <option value="11">11 - Nov</option>
                        <option value="12">12 - Dic</option>
                    </select>
                    <span style="width:20px; text-align: center"> / </span>
                    <select class="form-control" style="width:100px"
                    name="year_expiration" value="{{ old('year_expiration', $paymentcard->year_expiration) }}" required>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>

                <p class="text-danger">{{ $errors->first('month_expiration') }}</p>
                <p class="text-danger">{{ $errors->first('year_expiration') }}</p>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV
                    <i class="fa fa-question-circle"></i></label>
                <input class="form-control" type="text" min="000" max="999" maxlength="3" style="width: 100px"
                name="security_code" value="{{ old('security_code', $paymentcard->security_code) }}" required>

                <p class="text-danger">{{ $errors->first('security_code') }}</p>

            </div> <!-- form-group.// -->
        </div>
    </div> <!-- row.// -->

    <p class="alert alert-success"> <i class="fa fa-lock"></i> Some secureity information Lorem
        ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>

    <!-- <input type="hidden" name="cart_id" value="{{ $openCart->id }}"> -->
    <button type="submit" name="user_id" value="{{ $user->id }}" 
    class="subscribe btn btn-primary btn-block"> Confirmar </button>
</form>
