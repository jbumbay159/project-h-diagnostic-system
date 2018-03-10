<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReqTransaction extends Model
{
    protected $fillable = [
        'user_id','sale_id','remarks','status','customer_id',
    ];

    public function sale()
    {
    	return $this->hasOne('App\Sale', 'id', 'sale_id');
    }

    public function customer()
    {
    	return $this->hasOne('App\Customer', 'id','customer_id');
    }
}
