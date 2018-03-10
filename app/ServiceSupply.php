<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceSupply extends Model
{
    protected $fillable = [
        'service_id', 'supply_id', 'qty',
    ];
}
