<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyPricing extends Model
{
    protected $fillable = [
        'package_id','agency_id','pricing_type_id','country_id','price',
    ];

    public function package()
    {
    	return $this->hasOne('App\Package', 'id', 'package_id');
    }

    public function agency()
    {
    	return $this->hasOne('App\Agency', 'id', 'agency_id');
    }

    public function pricingType()
    {
    	return $this->hasOne('App\PricingType', 'id', 'pricing_type_id');
    }

}
