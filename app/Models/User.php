<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public $timestamps = false;

    public function getName(){
        if($this->customers->count() != 0){
            return $this->customers()->whereLogin(true)->first()->name;
        }else{
            return explode("@", $this->email)[0];
        }
    }
    public function customers(){
        return $this->hasMany('App\Models\CustomerAccount');
    }
}
