<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'association_id',
    ];
    
    public function customer()
    {
    	return $this->belongsToMany('App\Customer');
    }
    
    public function association()
    {
    	return $this->hasOne('App\Association', 'id', 'association_id');
    }
}
