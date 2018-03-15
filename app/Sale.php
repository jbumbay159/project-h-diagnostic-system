<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['_token','_method'];

    public function payments()
    {
    	return $this->hasMany('App\Payment');
    }

    public function labResults()
    {
        return $this->hasMany('App\LabResult');
    }
    
    public function transmittal()
    {
        return $this->hasOne('App\Transmittal');
    }
    
    public function customer()
    {
        return $this->hasOne('App\Customer','id','customer_id');
    }
    
    public function agency()
    {
        return $this->hasOne('App\Agency','id','agency_id');
    }

    public function reqTransaction()
    {
        return $this->hasMany('App\ReqTransaction');
    }

    public function inventoryLabItem()
    {
        return $this->hasMany('App\InventoryLabResultItem');
    }

    public function saleDiscount()
    {
        # code...
    }
}
