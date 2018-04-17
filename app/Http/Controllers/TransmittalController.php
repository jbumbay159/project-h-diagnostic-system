<?php

namespace App\Http\Controllers;

use Request;
use App\Customer;
use DB;
use App\Transmittal;
use Carbon\Carbon;

class TransmittalController extends Controller
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
        $info = NULL;
        $trans = NULL;
        $count = 0;
        $expiryDate = NULL;
        if (Request::get('id') != NULL) {
            $info = Customer::findOrFail(Request::get('id'));
            $trans = $info->transmittal()->orderBy('encode_date','DESC')->first();
            $expiryDate = Carbon::parse($info->expirationDate->created_at)->addDays($info->expirationDate->days);
        }
        
        $customer = Customer::all()->pluck('fullName','id');

        $dateNow = Carbon::now();
        $status = [
            7=>'PENDING',
            1=>'FIT TO WORK',
            2=>'UNFIT TO WORK',
            3=>'RECOMMENDED',
            4=>'NOT RECOMMENDED',
            5=>'FOR MMR VACCINE',
            6=>'MMR VACCINE',
            
        ];
        // dd($dateNow);

        return view('transmittal.index', compact('customer','info','count','trans','dateNow','status','expiryDate'));
    }

    public function store()
    {
        Request::validate([
            'customer_id' => 'required',
            'status_id' => 'required',
            'remarks' => 'required',
            'encode_date' => 'required',
        ]);   
        
        $all = Request::all();
        $info = Customer::findOrFail($all['customer_id']);
        $agency = $info->agency()->orderBy('pivot_created_at','desc')->first();
        
         $status = [
            7=>'PENDING',
            1=>'FIT TO WORK',
            2=>'UNFIT TO WORK',
            3=>'RECOMMENDED',
            4=>'NOT RECOMMENDED',
            5=>'FOR MMR VACCINE',
            6=>'MMR VACCINE',
        ];
        $status_id = $all['status_id'];
        $all = array_add($all, 'status',$status[$status_id]);
        $all = array_add($all, 'agency_id', $agency->id );
        

        $trans = Transmittal::create($all);
        
        session()->flash('success_message', 'Transmittal Added successfully..');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trans = Transmittal::findOrFail($id);
        $info = $trans->customer;
        $status = [
            7=>'PENDING',
            1=>'FIT TO WORK',
            2=>'UNFIT TO WORK',
            3=>'RECOMMENDED',
            4=>'NOT RECOMMENDED',
            5=>'FOR MMR VACCINE',
            6=>'MMR VACCINE',
        ];
        // dd($status[1]);
        return view('transmittal.show', compact('trans','info','status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    public function update($id)
    {
        Request::validate([
            'status_id' => 'required',
            'remarks' => 'required',
        ]);
        
        $all = Request::all();
        $trans = Transmittal::findOrFail($id);
        $status = [
            1=>'UNFIT TO WORK',
            2=>'FIT TO WORK',
            3=>'RECOMMENDED',
            4=>'NOT RECOMMENDED',
            5=>'FOR MMR VACCINE',
            6=>'MMR VACCINE',
        ];
        $status_id = $all['status_id'];
        
        $data = [
            'status_id' => $status_id,
            'status' => $status[$status_id],
            'remarks' => $all['remarks'],
        ];
        if ($status_id != 1) {
            $data = array_add($data, 'encode_date', Carbon::now()->toDateString());
        }
        $trans->update($data);
        
        session()->flash('success_message', 'Transmittal updated successfully..');
        return redirect()->back();
    }

    public function list()
    {
        $transmittal = NULL;
        if ( Request::get('date_from') != NULL AND Request::get('date_to') != NULL ) {
            $date_from = Request::get('date_from');
            $date_to =  Request::get('date_to');

            $transmittal = Transmittal::whereDate('encode_date','>=',$date_from)->whereDate('encode_date','<=',$date_to)->with(['customer'])->get()->groupBy('agencyName');   
            $dateExist = true;
        }else{
            $date_from = NULL;
            $date_to =  NULL;
            $dateExist = false;
        }
        
        
        return view('transmittal.list', compact('dateExist','transmittal','date_from','date_to'));
    }


}
