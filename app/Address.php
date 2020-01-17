<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address', 'city', 'state', 'zip'
     ];
 
    public function user(){
        return $this->belongsToMany('App\User', 'user_address', 'user_id', 'address_id');
        // return $this->belongsToMany('App\User');
    }

    public function shipments(){
        return $this->hasMany('App\Shipment','id');
    }

    public function scopeLastAdded($query) {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
