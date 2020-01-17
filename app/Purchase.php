<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['cart_id', 'shipment_id', 'paymentmethod_id', 'paymentcard_id', 'discount_id', 
    'currency', 'shipping_price', 'tax_perc', 'total_price', 'invoice_url', 'comments'];

    protected $table = 'purchases';
    
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
