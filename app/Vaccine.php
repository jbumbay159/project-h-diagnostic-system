<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vaccine extends Model
{
    protected $guarded = ['_token'];

    public function customer()
    {
    	return $this->hasOne('App\Customer','id','customer_id');
    }

    public function getDateGivenNameAttribute()
    {
    	return Carbon::parse($this->date_given)->format('F d, Y');
    }
}
