<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name', 'address', 'contact_person', 'contact_number',
    ];

    public function customer()
    {
        return $this->belongsToMany('App\Customer');
    }
    
    public function sales()
    {
    	return $this->hasMany('App\Sale');
    }
    
    public function transmittal()
    {
        return $this->hasMany('App\Transmittal');
    }

    public function emailAddress()
    {
        return $this->hasMany('App\AgencyEmail');
    }

    public function contacts()
    {
        return $this->hasMany('App\AgencyContact');
    }

}
