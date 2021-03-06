<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InventoryLabResultItem extends Model
{
    protected $fillable = [
        'customer_id' , 'sale_id','lab_result_id','supply_id','testqty','status',
    ];

    protected $guarded = ['_token','_method'];


    public function getDateReceiveAttribute()
    {
    	return Carbon::parse($this->created_at)->toDateString();
    }

    public function supply()
    {
    	return $this->hasOne('App\Supply','id','supply_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer','id','customer_id');
    }
}
