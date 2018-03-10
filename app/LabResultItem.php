<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabResultItem extends Model
{
    protected $fillable = [
        'lab_result_id' , 'name', 'group', 'normal_values', 'co_values', 'result', 'remarks',
    ];

}
