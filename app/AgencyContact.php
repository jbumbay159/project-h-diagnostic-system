<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyContact extends Model
{
    protected $fillable = [
        'name', 'contact',
    ];
}
