<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['email', 'fullname', 'order', 'reason', 'textarea'];

    protected $table = 'contacts';

    //protected $primaryKey = 'id';
}
