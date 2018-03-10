<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmittal extends Model
{
    protected $guarded = ['_token'];
    
    public function customer()
    {
        return $this->hasOne('App\Customer','id','customer_id');
    }
    
    public function agency()
    {
        return $this->hasOne('App\Agency','id','agency_id');
    }

    public function getAgencyNameAttribute()
    {
        return $this->agency->name;
    }
    
}
