<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['address_id','shipping_day','reception_day'];

    protected $table = 'shipments';

    public function address() {
        return $this->belongsTo('App\Address');
    }

    public function purchases(){
        return $this->hasMany('App\Purchase','id');
    }
}
