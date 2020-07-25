<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    //
    protected $table='p_users';
    protected $primaryKey='user_id';
    public $timestamps = false;
    protected $fillable=["user_id","user_name","user_email","user_pwd"];
}
