<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Supply extends Model
{
 	protected $fillable = [
        'name','min_qty','test_per_unit','unit','remarks'
    ];

    public function getMinimumQtyAttribute()
    {
    	$totalTest = $this->minExpQty *  $this->test_per_unit;
    	return "{$this->minExpQty} {$this->unit} / {$totalTest} Test";
    }

    public function getUpdatedDateAttribute()
    {
    	return Carbon::parse($this->updated_at)->toFormattedDateString();
    }

    public function getMinExpQtyAttribute()
    {
        list($resultInt, $resultDecimal) = explode(".", $this->min_qty);
        return ($resultDecimal != 0) ? $this->min_qty : $resultInt ;
    }

    public function getCurrentQtyAttribute()
    {

        if ($this->inventoryReceive()->count() == 0) {
            $quantity = 0.0;
        }else{
            $totalReceive = $this->inventoryReceive()->sum('quantity');
            
            $totalReturn = $this->inventoryReturn()->sum('quantity');
            
            $totalTest =  $this->test_per_unit * ($totalReceive - $totalReturn);

            $testUse = $this->inventoryLabResultItem()->where('status',1)->sum('testqty');
            $diffTest = $totalTest - $testUse;

            $totalAvail = $diffTest / $this->test_per_unit;
            $totalQty = bcdiv($totalAvail, 1, 1);

            list($resultInt, $resultDecimal) = explode(".", $totalQty);
            $quantity = ($resultDecimal != 0) ? number_format($totalQty,1) : number_format($resultInt, 0);
        }

        
        return $quantity; 
    }

    public function getCurrentTestAttribute()
    {
        if ($this->inventoryReceive()->count() == 0) {
            $quantity = 0;
        }else{
            $totalReceive = $this->inventoryReceive()->sum('quantity');
           
            $totalReturn = $this->inventoryReturn()->sum('quantity');

            $totalTest =  $this->test_per_unit * ( $totalReceive - $totalReturn);

            $testUse = $this->inventoryLabResultItem()->where('status',1)->sum('testqty');
            $diffTest = $totalTest - $testUse;
            // $totalAvail = ( $diffTest / $totalReceive);
            $quantity = $diffTest;
        }
        return number_format($quantity, 0,'.',',');
    }

    public function inventoryReceive()
    {
        return $this->hasMany('App\InventoryReceiveItem');
    }

    public function inventoryReturn()
    {
        return $this->hasMany('App\InventoryReturnItem');
    }

    public function inventoryLabResultItem()
    {
        return $this->hasMany('App\InventoryLabResultItem');
    }
    
}
