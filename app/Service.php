<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'category_id','is_xray',
    ];
    
    public function packages()
    {
      return $this->belongsToMany('App\Package');
    }
    
    public function item()
    {
    	return $this->hasMany('App\Service_item');
    }
    
    public function category()
    {
    	return $this->hasOne('App\Category','id','category_id');
    }

    public function prices()
    {
        return $this->hasMany('App\ServicePrice','service_id','id');
    }

    public function getAllPricesAttribute()
    {
        $price = "";
        foreach ($this->prices as $data) {
            $price .= "{$data->price}/" ;
        }
        return substr($price, 0, -1);
    }

    public function supplies()
    {
        return $this->hasMany('App\ServiceSupply');
    }

    public function covnv($value='')
    {
        $countNotNull = 0;
        foreach($this->item as $data){
            if($data->$value != NULL){
                $countNotNull++;
            }
        }
        return ($countNotNull > 0) ? true : false ;
    }

}
