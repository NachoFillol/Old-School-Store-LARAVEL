<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['type'];
    protected $table = 'user_type';

    public function users(){
        return $this->hasMany('App\User','id');
    }
}
