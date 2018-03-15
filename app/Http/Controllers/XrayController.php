<?php

namespace App\Http\Controllers;

use Request;
use App\Customer;
use App\Role;
use Carbon\Carbon;
use App\XrayResult;
use App\LabResult;
use App\User;
use Auth;

class XrayController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }
    
    public function index()
    {
        $customer = Customer::get()->pluck('fullName','id');
        $info = NULL;
        $labResults = NULL;
        $currentUser = Auth::user();
        $dateNow = Carbon::now()->toDateString();

        $users = Role::where('name','radiologist')->first()->users()->get()->pluck('fullName','id');
        if ( Request::get('customer') != NULL ) {
        	$customerID = Request::get('customer');
        	$info = Customer::findOrFail($customerID);
        	$labResults = $info->labResults()->with(['sale','service'])->where('is_done',0)->get()->where('isxray',1)->pluck('name','id');
        }

        return view('x-ray.index', compact('customer','info','labResults','currentUser','users','dateNow'));
    }


    public function store()
    {
    	Request::validate([
            'radiologist_id' => 'required',
            'lab_result_id' => 'required',
            'file_no' => 'required',
            'date_given' => 'required',
            'clinical_data' => 'required',
        ]);   

        $all = Request::all();

        $currentUser = Auth::user();
        $radiologist = User::findOrFail($all['radiologist_id']);
        $labResults = LabResult::findOrFail($all['lab_result_id']);

        $data= [
        	'customer_id' => $labResults->customer_id,
        	'lab_result_id' => $labResults->id,
        	'file_no' => $all['file_no'],
        	'date' => $all['date_given'],
        	'clinical_data' => $all['clinical_data'],
        	'prepared_id' => $currentUser->id,
        	'radiologist_id' => $radiologist->id,
        ];
        $xray = XrayResult::create($data);
        $labResults->update(['is_done'=>1]);

        session()->flash('success_message', 'Test assigned to '.$radiologist->fullName.' successfully.');
        return redirect()->back();
    }

    public function show($id)
    {
    	# code...
    }


    public function edit($id)
    {
    	$currentUser = Auth::user();
    	$currentUser->authorizeRoles(['administrator','radiologist']);

    	$xrayResult = XrayResult::findOrFail($id);

    	return view('x-ray.edit',compact('xrayResult'));
    }

    public function update($id)
    {
    	$all = Request::all();
    	$xrayResult = XrayResult::findOrFail($id);

    	$xrayResult->update($all);
    	session()->flash('success_message', 'X-ray result added successfully.');
    	return redirect()->back();
    }

    public function radiologist()
    {
    	$currentUser = Auth::user();
    	$currentUser->authorizeRoles(['administrator','radiologist']);

    	$userRole = Auth::user()->roles()->whereIn('name', ['administrator','radiologist'])->first()->name;
    	if ($userRole == 'administrator') {
    		$xrayResults = XrayResult::get();
    	}else{
    		$xrayResults = XrayResult::where('radiologist_id',$currentUser->id)->get();
    	}

    	return view('x-ray.radiologist',compact('xrayResults'));
    }

    public function radiologistPrint($id)
    {
    	$xrayResult = XrayResult::findOrFail($id);
    	return view('x-ray.print',compact('xrayResult'));
    }
}
