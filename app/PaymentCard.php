<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    protected $fillable = ['user_id','owner','number','month_expiration','year_expiration','security_code'];

    protected $table = 'paymentcards';

    public function user() {
        return $this->belongsTo('App\User');
    }
}
