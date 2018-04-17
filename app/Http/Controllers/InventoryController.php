<?php

namespace App\Http\Controllers;

use Request;
use App\Supply;
use DataTables;
use Carbon\Carbon;
use App\InventoryReceive;
use App\InventoryReceiveItem;
use App\InventoryReturn;
use App\Customer;
use App\InventoryLabResultItem;


class InventoryController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }

    public function index()
    {
        if (Request::get('print') != NULL) {
            $supplies = Supply::get();
            return view('inventory.printAll', compact('supplies'));
        }else{
            return view('inventory.index');    
        }
    	
    }

    public function store()
    {
    	$all = Request::all();
    	if (Request::get('date_received') != NULL) {
    		$inventoryItems =  InventoryReceive::create($all);
    		$receiveItems = session()->pull('receive.items');
    		foreach ($receiveItems as $items) {
    			$data = [
    				'supply_id' => $items['supply'],
    				'quantity' => $items['qty'],
    				'date_expired' => $items['exp_date'],
    				'lot_number' => $items['lot_number'],
                    'price' => $items['price'],
    			];
    			$inventoryItems->items()->create($data);
    		}
    		session()->flash('success_message', 'Received item(s) save Successfully.');
    	}else{
            $inventoryItems =  InventoryReturn::create($all);
            $returnItems = session()->pull('return.items');
            foreach ($returnItems as $items) {
                $data = [
                    'supply_id' => $items['supply'],
                    'quantity' => $items['qty'],
                    'date_expired' => $items['exp_date'],
                    'lot_number' => $items['lot_number'],
                    'remarks' => $items['remarks'],
                ];
                $inventoryItems->items()->create($data);
            }

    		session()->flash('success_message', 'Returned item(s) save Successfully.');
    	}
    	return redirect()->back();
    }

    public function show($id)
    {
        $supply = Supply::findOrFail($id);
        $list = [];

        $inventoryReceive = $supply->inventoryReceive()->get();
        $inventoryReturn = $supply->inventoryReturn()->get();
        $inventoryLabResultItem = $supply->inventoryLabResultItem()->get();

        // Receive 
        foreach ($inventoryReceive->groupBy('dateReceive') as $receiveKey => $receiveValue) {
            $totalQty = 0;
            foreach( $receiveValue as $receiveData){
                $totalQty += $receiveData->quantity;
                $unitName = $receiveData->supply->unit;
            }
            $list[] = [
                'date' => Carbon::parse($receiveKey)->toFormattedDateString(),
                'quantity' => number_format($totalQty).' '.$unitName,
                'status' => 'Received',
                'state' => 'success',
            ];
        }

        // LabResult 
        foreach ($inventoryLabResultItem->groupBy('dateReceive') as $resultKey => $resultValue) {
            $totalQty = 0;
            $totalTest = 0;
            foreach( $resultValue as $resultData){
                if ($resultData->status == 1) {
                    $totalTest += $resultData->testqty;
                    $totalQty =  $totalTest /$resultData->supply->test_per_unit;
                    $unitName = $resultData->supply->unit;
                }
            }

            $list[] = [
                'date' => Carbon::parse($resultKey)->toFormattedDateString(),
                'quantity' => number_format($totalQty, 1).' '.$unitName,
                'status' => 'Sold',
                'state' => 'info',
            ];
        }

        // Return
        foreach ($inventoryReturn->groupBy('dateReturn') as $returnKey => $returnValue) {
            $totalQty = 0;
            foreach ($returnValue as $returnData) {
                $totalQty += $returnData->quantity;
                $unitName = $returnData->supply->unit;
            }

            $list[] = [
                'date' => Carbon::parse($returnKey)->toFormattedDateString(),
                'quantity' => number_format($totalQty).' '.$unitName,
                'status' => 'Returned',
                'state' => 'danger',
            ];
        }

        return view('inventory.show',compact('supply','inventoryReceive','inventoryLabResultItem','list'));
    }

    public function editReceiveItem($id)
    {
        $all = Request::all();
        $receiveItems = session()->pull('receive.items.'.$id);
        $all = array_add($all,'supply', $receiveItems['supply']);
        $all = array_add($all,'unit',$receiveItems['unit']);
        $all = array_add($all,'prodName',$receiveItems['prodName']);
        $all = array_add($all,'remarks',$receiveItems['remarks']);
        $all = array_add($all,'price',$receiveItems['price']);

        session()->push('receive.items', $all);
        session()->flash('success_message', 'Item Updated Successfully');
        return redirect()->back();
    }

    public function removeReceiveItem($id)
    {
    	$report = session()->forget('receive.items.'.$id);
        session()->flash('danger_message', 'Item Removed Successfully');
    	return redirect()->back();
    }

    public function receive()
    {
    	$receiveItems = session()->get('receive.items');
    	// dd($receiveItems);
    	$supply = Supply::pluck('name','id');
    	return view('inventory.receive',compact('receiveItems','supply'));
    }

    public function addReceiveItem()
    {
    	Request::validate([
            'student' => 'exists:supplies,id',
            'qty' => 'required',
        ]);  

    	$all = Request::all();
    	$supply = Supply::findOrFail($all['supply']);
    	$all = array_add($all,'unit',$supply->unit);
    	$all = array_add($all,'prodName',$supply->name);
    	session()->push('receive.items', $all);
    	
    	session()->flash('success_message', 'Item Added Successfully..');
    	return redirect()->back();
    }

    public function return()
    {

        $returnItems = session()->get('return.items');
        $supply = Supply::pluck('name','id');
        return view('inventory.return',compact('returnItems','supply'));
    }

    public function addReturnItem()
    {
        Request::validate([
            'supply' => 'exists:supplies,id',
            'qty' => 'required',
            'lot_number' => 'required',
            'remarks' => 'required',
        ]); 

        $all = Request::all();
        
        $itemExist = InventoryReceiveItem::where('supply_id',$all['supply'])->where('lot_number',$all['lot_number'])->where('date_expired',$all['exp_date']);
        
        if ($itemExist->exists() == true AND $itemExist->sum('quantity') >= $all['qty'] AND $all['qty'] > 0) {    
            $supply = Supply::findOrFail($all['supply']);
            $all = array_add($all,'unit',$supply->unit);
            $all = array_add($all,'prodName',$supply->name);
            session()->push('return.items', $all);

            session()->flash('success_message', 'Item Added Successfully');
        }else{
            session()->flash('danger_message', 'Item not exist. ');
        }
        
        return redirect()->back();
    }

    public function editReturnItem($id)
    {
        $all = Request::all();
        $receiveItems = session()->pull('return.items.'.$id);
        $all = array_add($all,'supply', $receiveItems['supply']);
        $all = array_add($all,'unit',$receiveItems['unit']);
        $all = array_add($all,'prodName',$receiveItems['prodName']);
        $all = array_add($all,'lot_number',$receiveItems['lot_number']);
        $all = array_add($all,'exp_date',$receiveItems['exp_date']);


        session()->push('return.items', $all);
        session()->flash('success_message', 'Item Updated Successfully');
        return redirect()->back();
    }

    public function removeReturnItem($id)
    {
        $report = session()->forget('return.items.'.$id);
        session()->flash('danger_message', 'Item Removed Successfully');
        return redirect()->back();
    }

    public function data()
    {
    	$data = Supply::get();

        return DataTables::of($data)
        ->addColumn('qty',function ($item) {
            return floor($item->currentQty).' '.$item->unit.' / '.$item->currentTest.' Test';
        })
        ->addColumn('minimumQty',function ($item) {
            return $item->minimumQty;
        })
        ->addColumn('updated_at',function ($item) {
            return $item->updatedDate;
        })
        ->addColumn('action',function ($item) {
            return  '<div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="'.action("InventoryController@show",$item->id).'"><span class="icon-eye-open"></span> Detail</a></li>
                        </ul>
                    </div>
                </div>';
        })
  		->make(true);
    }

    public function filter($type)
    {
        $supplies = [];
        $itemArray = [];
        $nowDate = Carbon::now()->toDateString();
        if ($type == 'critical-level') {
            $supplies = Supply::get()->where('currentQty','=<','minimumQtyNoTest');
        }elseif ($type == 'expired') {
            $supplies = Supply::get();
            foreach ($supplies as $supply) {
                $currentQty = $supply->currentQty;
                
                foreach ($supply->inventoryReceive()->orderBy('created_at','DESC')->get() as $receive) {
                    if ($receive->quantity >= $currentQty ) {
                        $currentQty = $receive->quantity - $currentQty;

                        $itemArray[] = [
                            'qty'=> $receive->quantity - $currentQty,
                            'dateExp'=> $receive->date_expired,
                            'name' => $receive->supply->name,
                            'unit' => $receive->supply->unit,
                        ];

                        if ($currentQty <= 0) {
                            break;
                        }
                    }else{
                        $currentQty -= $receive->quantity;
                        $itemArray[] = [
                            'qty'=> $receive->quantity,
                            'dateExp'=> $receive->date_expired,
                            'name' => $receive->supply->name,
                            'unit' => $receive->supply->unit,
                        ];
                    }
                }   
            }
            // dd($itemArray);
            foreach ($itemArray as $key => $item) {
                if ($item['dateExp'] >= Carbon::now()->toDateString() ) {
                    unset($itemArray[$key]);
                }elseif( $item['dateExp'] == NULL) {
                    unset($itemArray[$key]);
                }
            }
        }elseif ($type == 'nearing-expiry'){
            $supplies = Supply::get();
            foreach ($supplies as $supply) {
                $currentQty = $supply->currentQty;
                
                foreach ($supply->inventoryReceive()->orderBy('created_at','DESC')->get() as $receive) {
                    if ($receive->quantity >= $currentQty ) {
                        $currentQty = $receive->quantity - $currentQty;

                        $itemArray[] = [
                            'qty'=> $receive->quantity - $currentQty,
                            'dateExp'=> $receive->date_expired,
                            'name' => $receive->supply->name,
                            'unit' => $receive->supply->unit,
                        ];

                        if ($currentQty <= 0) {
                            break;
                        }
                    }else{
                        $currentQty -= $receive->quantity;
                        $itemArray[] = [
                            'qty'=> $receive->quantity,
                            'dateExp'=> $receive->date_expired,
                            'name' => $receive->supply->name,
                            'unit' => $receive->supply->unit,
                        ];
                    }
                }   
            }
            // dd($itemArray);
            $nearingExpiry = Carbon::now()->addMonths(3)->toDateString();
            foreach ($itemArray as $key => $item) {
                if ($item['dateExp'] < $nowDate || $item['dateExp'] > $nearingExpiry ) {
                    unset($itemArray[$key]);
                }elseif( $item['dateExp'] == NULL) {
                    unset($itemArray[$key]);
                }
            }
        }

        if (Request::get('print') != NULL) {
            return view('inventory.printFilter',compact('supplies','type','itemArray'));  
        }else{
            return view('inventory.filter',compact('supplies','type','itemArray'));    
        }
        
    }

    public function labUsage()
    {
        $customers = Customer::orderBy('last_name')->get()->pluck('fullName', 'id');
        $supply = Supply::pluck('name','id');
        $items = InventoryLabResultItem::get();


        return view('inventory.lab-usage',compact('supply','customers','items'));
    }

    public function addLabUsage()
    {
        $all = Request::all();
        $all = array_add($all, 'status', 1);
        $item = InventoryLabResultItem::create($all);


        session()->flash('success_message', 'Item Added Successfully..');
        return redirect()->back();
    }
    
}
