<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReturnItem extends Model
{
    protected $fillable = [
        'inventory_return_id' , 'supply_id','quantity','lot_number','date_expired','remarks',
    ];

    protected $touches = ['supply'];

    public function supply()
    {
    	return $this->hasOne('App\Supply','id','supply_id');
    }

    public function getDateReturnAttribute()
    {
    	return $this->parent->date_return;
    }

    public function parent()
    {
    	return $this->hasOne('App\InventoryReturn','id','inventory_return_id');
    }
}
