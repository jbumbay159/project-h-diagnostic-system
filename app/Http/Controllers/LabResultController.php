<?php

namespace App\Http\Controllers;

use Request;
use DB;
use App\Customer;
use App\LabResult;


class LabResultController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $customer = Customer::select(DB::raw("concat(last_name,', ',first_name,' ',middle_name ) AS name"), 'id')->pluck('name','id');
        $array = Customer::get();
        $customer = array_pluck($array, 'fullName', 'id');

        return view('lab-result.index', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $all = Request::all();
        $customer = Customer::findOrFail($all['customer']);
        return redirect()->action('LabResultController@show', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Customer::with(['agency','labResults'])->findOrFail($id);
        // $trans = $info->transmittal()->orderBy('encode_date','DESC')->first();
        $labResults = $info->labResults()->with(['sale','service'])->where('is_done',0)->get();
        $customer = Customer::get()->pluck('fullName', 'id');
        return view('lab-result.show', compact('info','customer','labResults'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $labResult = LabResult::findOrFail($id);
        $data = $labResult;
        $info = Customer::findOrFail($labResult->customer_id);
        $trans = $info->transmittal()->orderBy('encode_date','DESC')->first();
        return view('lab-result.edit', compact('info','labResult','trans','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $all = Request::all();
        $service = LabResult::findOrFail($id);
        $all = array_add($all,'is_done',1);
        $result = $service->update($all);

        if ( Request::get('id') != NULL || count(Request::get('id')) > 0 ) {
            foreach ($all['id'] as $key => $value) {
                $data = [
                    'result' => $all['result'][$key],
                    'remarks' => $all['remarks_val'][$key],
                ];
                $list = $service->items()->findOrFail($value)->update($data);
            }
        }

        session()->flash('success_message', 'Result Added Successfully..');
        return redirect()->action('LabResultController@edit',$id);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printResult($id)
    {

        // $labResults = LabResult::findOrFail($id);
        // dd($id);
        // $info = Customer::findOrFail($labResults->customer_id);

        // return view('lab-result.print', compact('info','labResults','data'));
    }
}
