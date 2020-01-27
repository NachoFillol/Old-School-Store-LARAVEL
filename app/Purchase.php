<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['cart_id', 'shipment_id', 'paymentmethod_id', 'paymentcard_id', 'discount_id', 
    'currency', 'shipping_price', 'tax_perc', 'total_price', 'invoice_url', 'comments'];

    // Se crean variables para poder compartir calculos matematicos y otros al modelo
    // No Pueden tener mismo nombre que alguna de sus columnas !!!
    protected $appends = [
        'subtotal', 'total_discount', 'taxes', 'shipping_cost', 'final_price',
    ];

    protected $table = 'purchases';

    // Atributos dependientes de 'appends'
    public function getFinalPriceAttribute() 
    {
        return number_format($this->total_price, 2, ',', '');
    }

    public function getShippingCostAttribute()
    {
        return number_format($this->shipping_price, 2, ',', '');
    }

    public function getTaxesAttribute() 
    {
        return number_format($this->tax_perc, 2, ',', '');
    }

    public function getTotalDiscountAttribute()
    {
        return ($this->discount) ? number_format($this->discount->discount_perc, 2, ',', '') : 0;
    }

    public function getSubtotalAttribute() 
    {
        // Tiene en cuenta si no hay ningun dto. aplicado (NULL), debe hacer otro calculo
        if($this->discount) {
            $subtot = ((($this->total_price / (1 + $this->tax_perc / 100)) - $this->shipping_price) / ((-1 * ($this->discount->discount_perc / 100)) + 1));
            // Fla. p/dto:
            // Precio s/dto = Precio c/dto / (-x+1)    , donde -x = Valor % dto /100
        } else {
            $subtot = ((($this->total_price / (1 + $this->tax_perc / 100)) - $this->shipping_price));
        }
        
        return number_format(round($subtot, 2 , PHP_ROUND_HALF_DOWN), 2, ',', '');
    }
    
    public function cart() {
        return $this->belongsTo('App\Cart');
    }

    public function discount() {
        return $this->belongsTo('App\Discount');
    }

    public function paymentmethod() {
        return $this->belongsTo('App\PaymentMethod');
    }

    public function paymentcard() {
        return $this->belongsTo('App\PaymentCard');
    }

    public function shipment() {
        return $this->belongsTo('App\Shipment');
    }
}
