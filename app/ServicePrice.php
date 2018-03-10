<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'service_id', 'price',
    ];

    public function service()
    {
    	return $this->hasOne('App\Service','id','service_id');
    }

    public function getPriceNameAttribute()
    {
    	return "{$this->service->name} - ({$this->price})";
    }
}
