<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    protected $fillable = [
        'customer_id' , 'finger', 'templates','hash',
    ];
    
}
