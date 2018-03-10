<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReceive extends Model
{
    protected $fillable = [
        'date_received' , 'remarks'
    ];

    public function items()
    {
    	return $this->hasMany('App\InventoryReceiveItem');
    }
}
