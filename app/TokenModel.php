<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    //
   	protected $table='p_token';
    protected $primaryKey='id';
    public $timestamps = false;
}
