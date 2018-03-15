<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XrayResult extends Model
{
    protected $fillable = [
        'customer_id' , 'lab_result_id', 'file_no', 'date','clinical_data','remarks','impression','prepared_id','radiologist_id','is_done'
    ];


    public function preparedUser()
    {
    	return $this->hasOne('App\User','id','prepared_id');
    }

    public function radiologistUser()
    {
    	return $this->hasOne('App\User','id','radiologist_id');
    }

    public function customer()
    {
    	return $this->hasOne('App\Customer','id','customer_id');
    }

	public function labResult()
    {
    	return $this->hasOne('App\LabResult','id','lab_result_id');
    }    


}
