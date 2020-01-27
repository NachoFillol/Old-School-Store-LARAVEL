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

    public function getIcon() 
    {
        $icons = [
            3 => 'amex',
            4 => 'visa',
            5 => 'mastercard',
            6 => 'discover',
        ];

        $firstDigit = $this->number[0];

        if (array_key_exists($firstDigit, $icons)) {
            return $icons[$firstDigit];
        }

        return null;
    }
}
