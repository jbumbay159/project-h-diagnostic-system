<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabResultItem extends Model
{
    protected $fillable = [
        'lab_result_id' , 'name', 'group', 'normal_values', 'co_values', 'result', 'remarks',
    ];

    public function changes()
    {
    	return $this->hasMany('App\LabResultItemChange');
    }


    public function getChangeResultAttribute()
    {
    	if ($this->changes()->count() > 0) {
    		$result = $this->changes()->orderBy('created_at','DESC')->first()->result;
    	}else{
    		$result = $this->result;
    	}
    	return $result;
    }

    public function getChangeRemarksAttribute()
    {
    	if ($this->changes()->count() > 0) {
    		$result = $this->changes()->orderBy('created_at','DESC')->first()->remarks;
    	}else{
    		$result = $this->remarks;
    	}
    	return $result;
    }

    public function getCountChangesAttribute()
    {
    	$data = "";
    	$changeCount = $this->changes()->count();
    	for ($i=0; $i < $changeCount ; $i++) { 
    		$data .= "*";
    	}
    	

    	return $data;
    }

}
