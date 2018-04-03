<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_item extends Model
{
    protected $fillable = [
        'service_id', 'service', 'cov', 'group', 'nv','remarks',
    ];
}
