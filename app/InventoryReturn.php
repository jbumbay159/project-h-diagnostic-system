<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReturn extends Model
{
    protected $fillable = [
        'date_return' , 'remarks'
    ];

    public function items()
    {
    	return $this->hasMany('App\InventoryReturnItem');
    }
}
