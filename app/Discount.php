<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code', 'discount_perc'
     ];
 
    protected $table = 'discounts';

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function purchases(){
        return $this->hasMany('App\Purchase');
    }
}
