<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyEmail extends Model
{
    protected $fillable = [
        'name', 'email',
    ];
}
