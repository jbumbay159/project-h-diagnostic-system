<?php

namespace App\Http\Controllers;

use Request;
use App\Supply;
use DataTables;
use Session;

class SupplyController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$supply = Supply::all();
    	return view('supplies.index',compact('supply'));
    }

    public function create()
    {
    	return view('supplies.create');
    }

    public function store()
    {
        Request::validate([
            'name' => 'required|unique:supplies',
        ]);
        $all = Request::all();
        $supply = Supply::create($all);
    	
        session()->flash('success_message', 'Item Added Successfully'); 
        return redirect()->back();

    }

    public function edit($id)
    {
        $item = Supply::findOrFail($id);
    	return view('supplies.edit',compact('item'));
    }

    public function update($id)
    {
        Request::validate([
            'name' => 'required|unique:supplies,name,'.$id,
        ]);
        $all = Request::all();
        $supply = Supply::findOrFail($id)->update($all);
    
        session()->flash('success_message', 'Item Updated Successfully'); 
        return redirect()->back();
    }

    public function data()
    {
    	$data = Supply::get();

        return DataTables::of($data)
        ->addColumn('minimumQty',function ($item) {
            return $item->minimumQty;
        })
        ->addColumn('action', function ($item) {
        	return $this->dataActions($item->id);
        })->make(true);
    }

    public function dataActions($id)
    {
    	return  '<div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
	                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="'.action("SupplyController@edit",$id).'"><span class="icon-eye-open"></span> Edit</a></li>
                        </ul>
                    </div>
                </div>';
    }

    public function importData()
    {
        $all = Request::all();
        $csvFile = Request::file('importfile');

        $csvFile_extension = $csvFile->getClientOriginalExtension();
        if ($csvFile_extension == 'csv' && is_readable($csvFile)) {

            $supply = $this->csvToArray($csvFile);
            // dd($supply);
            foreach ($supply as $supplyVal) {
                // dd($supplyVal['name']);
                $data = [
                    'name' => $supplyVal['name'],
                    'min_qty' => $supplyVal['min_qty'],
                    'test_per_unit' => $supplyVal['test_per_unit'],
                    'remarks' => $supplyVal['remarks'],
                    'unit' => $supplyVal['unit'],
                ];
                Supply::firstOrCreate($data);
            }

            session()->flash('success_message', 'Data Imported Successfully'); 

        }else{
            session()->flash('danger_message', 'Invalid File'); 
        }
        return redirect()->back();
        
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    
}
