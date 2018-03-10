<?php

namespace App\Http\Controllers;

use Request;
use App\Package;
use App\Service;

class PackageController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$package = Package::all();
    	return view('package.index', compact('package'));
    }
    
    public function create()
    {
    	$service = Service::pluck('name','id');
    	return view('package.create', compact('service'));
    }
    
    public function store()
    {
        Request::validate([
            'name' => 'required|max:255|unique:packages',
            'price' => 'required|numeric',
            'days' => 'required|numeric',
            'service.*' => 'required',
        ],[
           'service.*.required'     =>      'Please select service' ,
        ]);
        
        $all = Request::all();
    	
        $package = Package::create($all);
        $package->services()->sync($all['service']);
        
        session()->flash('success_message', 'Package Created Successfully..');
        return redirect()->action('PackageController@edit', ['id' => $package->id]);
        
    }
    
    public function edit($id)
    {
    	$package = Package::findOrFail($id);
    	$service = Service::pluck('name','id');
    	
        
        
    	$service_id = $package->services()->first()->id;
        $serviceName = $package->services()->first()->name;
    	// $list =  $package->services()->get();
        $list = [$service_id => $serviceName];
        foreach ($package->services as $key => $data) {
            $list = array_add($list, $data->id, $data->name);
        }

        // dd($list);
    	return view('package.edit', compact('service_id','service','package','list'));
    }
    
    public function update($id)
    {
        Request::validate([
            'name' => 'required|max:255|unique:packages,name,'.$id,
            'price' => 'required|numeric',
            'days' => 'required|numeric',
            'service.*' => 'required',
        ],[
           'service.*.required'     =>      'Please select service' ,
        ]);

        
        
        $all = Request::all();
        
    	$package = Package::findOrFail($id);
        
        $result = $package->update($all);
        $package->services()->sync($all['service']);
        
        session()->flash('success_message', 'Package Updated Successfully..');
        return redirect()->back();
    }
}