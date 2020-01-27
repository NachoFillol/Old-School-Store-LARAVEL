<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Aca se declaran los campos que se pueden llenar de la tabla
    // No incluir id, created_at, updated_at y deleted_at
    protected $fillable = [
        'category_id', 'discount_id', 'name', 'code', 'colour',
        'currency', 'price', 'model', 'quality', 'status', 'stock',
        'description_detail', 'description_general', 'description_title',
        'description_model', 'description_quality', 'image'
    ];

    protected $table = 'products';

    protected $appends = [
        'product_qty',
    ];

    // Atributos dependientes de 'appends'
    public function getProductQty() 
    { 
        return ($this->pivot->product_qty <= $this->stock) ? $this->pivot->product_qty : 0;
    }

    
    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function user() {
        return $this->belongsToMany('App\User', 'favorites', 'user_id', 'product_id');
        // return $this->belongsToMany('App\User');
    }

    public function cart() {
        return $this->belongsToMany('App\Cart', 'cart_product', 'cart_id', 'product_id');
    }

    public function discount() {
        return $this->belongsTo('App\Discount');
    }


    // protected $hidden = ['factory_price'];  // No trae este campo en las consultas a Product

    // No hace falta aclarar que el id es la primaryKey por defecto
    //protected $primaryKey = 'id';

}
