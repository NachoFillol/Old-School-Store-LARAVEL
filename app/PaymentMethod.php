<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name'];

    protected $table = 'paymentmethods';

    public function purchases(){
        return $this->hasMany('App\Purchase');
    }
}
