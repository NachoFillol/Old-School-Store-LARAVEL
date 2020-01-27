<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    //protected $table = 'users'; // No es necesario ya que se llama igual que el Model (en plural)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'user_type_id','code', 'firstname', 'lastname', 'email', 'email2', 
       'password', 'gender', 'phone', 'avatar'
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // Son cosas a las que no deberia accederse de manera visual (en una vista).
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getNombreCompleto() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function rol() {
        return $this->belongsTo('App\UserType', 'user_type_id');
    }

    public function addresses() {
        return $this->belongsToMany('App\Address', 'user_address', 'user_id', 'address_id');
    }

    public function favorites() {
        return $this->belongsToMany('App\Product', 'favorites', 'user_id', 'product_id');
        // return $this->belongsToMany('App\Product');
    }

    public function carts() {
        return $this->hasMany('App\Cart');
    }

    public function paymentcards() {
        return $this->hasMany('App\PaymentCard');
    }

    public function cartInProgress() 
    {
        return $this->carts()->with('purchases')->openCart()->latest()->first();
    }
}
