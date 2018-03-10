<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'birthdate',
        'address',
        'contact_number',
        'remarks',
        'photo',
        'barcode',
    ];
    
    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name} {$this->middle_name} {$this->name_extension}";
    }

    public function getPhotosAttribute()
    {

        if ($this->photo != NULL) {
            if (strlen($this->photo) <= 16) {
                $imgPath = asset("public/img/".$this->photo);
            }else{
                $imgPath = $this->photo;
            }
        }else{
            $imgPath = asset("public/img/default.jpeg");
        }
        return $imgPath;
    }

    public function getCurrentAgencyAttribute()
    {
        return $this->agency()->orderBy('pivot_created_at','desc')->first();
    }

    public function getExpirationDateAttribute()
    {
        if ($this->sales()->count() > 0) {
            return $this->sales()->where('days','>',0)->orderBy('created_at','desc')->first();
        }else{
            return Carbon::now();
        }
        
    }

    public function vaccines()
    {
        return $this->hasMany('App\Vaccine');
    }

    public function getLastVaccineAttribute()
    {
        return $this->vaccines()->orderBy('date_given','DESC')->first()->date_given;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function reqTransaction()
    {
        return $this->hasMany('App\ReqTransaction');
    }
    
    public function country()
    {
    	return $this->belongsToMany('App\Country')->withPivot('id', 'created_at');
    }

    public function agency()
    {
        return $this->belongsToMany('App\Agency')->withPivot('id', 'created_at');
    }
    
    public function sales()
    {
    	return $this->hasMany('App\Sale');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function labResults()
    {
        return $this->hasMany('App\LabResult');
    }
    
    public function transmittal()
    {
        return $this->hasMany('App\Transmittal');
    }
    
    public function fingerPrint()
    {
        return $this->hasMany('App\Fingerprint');
    }
    
}
