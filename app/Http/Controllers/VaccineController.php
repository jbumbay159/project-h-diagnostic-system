<?php

namespace App\Http\Controllers;

use Request;
use App\Customer;
use Carbon\Carbon;
use App\Vaccine;
use App\Setting;

class VaccineController extends Controller
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
        $dateNow = Carbon::now()->toDateTimeString();

        $customerList = Customer::get();
        $customer = $customerList->pluck('fullName','id');

        $vaccines = Vaccine::with(['customer'])->get();
        $last = Vaccine::latest()->first();
        return view('vaccine.index', compact('customer','dateNow','vaccines','last','customerList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $vaccineNurse = Setting::where('set_name','vaccine_nurse')->first()->name;
        $vaccineLicense = Setting::where('set_name','vaccine_license')->first()->name;

        $all = Request::all();
        $customer = Customer::findOrFail($all['customer_id']);
        $all = array_add($all,'current_age', $customer->age );
        $all = array_add($all, 'nurse_name',$vaccineNurse);
        $all = array_add($all, 'lic_no',$vaccineLicense);
        $vaccine = Vaccine::create($all);

        $htmlDev = "<a href='vaccine/".$vaccine->id."' target='__blank'><button type='button' class='btn btn-warning'>Print</button></a>";
        $data[] = ['value' => $htmlDev];
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaccine = Vaccine::findOrFail($id);
        return view('vaccine.show', compact('vaccine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $vaccines = $customer->vaccines;

        return view('vaccine.edit', compact('customer','vaccines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
