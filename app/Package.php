<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name' , 'price', 'days',
    ];

    public function getNamePriceAttribute()
    {
    	return "{$this->name} - (".number_format($this->price, 2).")";
    }
    
    public function services()
    {
      	return $this->belongsToMany('App\Service');
    }

    
}
