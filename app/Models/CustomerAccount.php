<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'name', 'login'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
