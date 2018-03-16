<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LabResult extends Model
{
    protected $fillable = [
        'customer_id' , 'sale_id', 'name', 'remarks', 'interpret','category_name','service_id','file_no','is_done'
    ];

    public function items()
    {
    	return $this->hasMany('App\LabResultItem');
    }

    public function sale()
    {
    	return $this->hasOne('App\Sale', 'id', 'sale_id');
    }
    
    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }

    public function getCreatedDateAttribute()
    {
        return  Carbon::parse($this->created_at)->toFormattedDateString();
    }

    public function getIsxrayAttribute()
    {
        return $this->service->is_xray;
    }

    public function getUpdatedDateAttribute()
    {
        return Carbon::parse($this->updated_at)->toDateString();
    }

    


    public function covnv($value='')
    {
        $countNotNull = 0;
        foreach($this->items as $data){
            if($data->$value != NULL){
                $countNotNull++;
            }
        }
        return ($countNotNull > 0) ? true : false ;
    }
}
