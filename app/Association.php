<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    protected $fillable = [
        'name',
    ];

    public function country()
    {
    	return $this->hasMany('App\Country');
    }
}
