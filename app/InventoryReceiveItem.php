<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReceiveItem extends Model
{
    protected $fillable = [
        'inventory_receive_id' , 'supply_id','quantity','lot_number','date_expired',
    ];

    protected $touches = ['supply'];

    public function supply()
    {
    	return $this->hasOne('App\Supply','id','supply_id');
    }

    public function getDateReceiveAttribute()
    {
    	return $this->parent->date_received;
    }

    public function parent()
    {
    	return $this->hasOne('App\InventoryReceive','id','inventory_receive_id');
    }
}
