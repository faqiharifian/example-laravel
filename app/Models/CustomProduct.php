<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomProduct extends Model
{
    protected $guarded = ['id'];

    public function images(){
        return $this->hasMany('App\Models\CustomProductImage', 'custom_product_id', 'id');
    }
}
