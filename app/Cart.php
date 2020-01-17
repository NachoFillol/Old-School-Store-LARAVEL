<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'status'];

    protected $table = 'carts';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function products() {
        return $this->belongsToMany('App\Product', 'cart_product', 'cart_id', 'product_id')->withPivot('product_qty');  // withPivot le pide 'product_qty' a la tabla intermedia 'cart_product'
    }

    public function purchases() {
        return $this->hasMany('App\Purchase');
    }

    public function scopeOpenCart($query) 
    {
        //$query->where('status', 'open');
        $query->whereIn('status', ['open','payment','shipment','review']);

        return $query;
    }

    public function scopeClosedCarts($query) {

        $query->where('status', 'closed')->orderBy('updated_at', 'desc');

        return $query;
    }

    public function scopeCancelledCarts($query) {

        $query->where('status', 'cancelled')->orderBy('updated_at', 'desc');

        return $query;
    }
}
