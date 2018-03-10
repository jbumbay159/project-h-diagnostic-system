<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InventoryLabResultItem extends Model
{
    protected $fillable = [
        'customer_id' , 'sale_id','lab_result_id','supply_id','testqty','status',
    ];


    public function getDateReceiveAttribute()
    {
    	return Carbon::parse($this->created_at)->toDateString();
    }

    public function supply()
    {
    	return $this->hasOne('App\Supply','id','supply_id');
    }
}
