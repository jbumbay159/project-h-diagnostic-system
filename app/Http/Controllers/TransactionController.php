<?php

namespace App\Http\Controllers;

use Request;
use App\ReqTransaction;
use App\Customer;
use App\Sale;

class TransactionController extends Controller
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
        $trans = ReqTransaction::all();
        $customer = Customer::all()->pluck('fullName','id');
        return view('transaction.index', compact('trans','customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Request::validate([
            'transcode.*' => 'required|exists:sales,transcode|numeric',
            'remarks' => 'required',
        ],[
            'transcode.*.exists'     =>      "Transaction didn't exist" ,
        ]);

        $all = Request::all();
        $sale = Sale::where('transcode',$all['transcode']);
        if ($sale->exists()) {
            $saleData = $sale->first();
            $data = [
                'sale_id' =>  $saleData->id,
                'customer_id' => $saleData->customer_id,
                'remarks' => $all['remarks'],
                'status' => 2,
            ];
            $sale->update(['status' => 2]);
            $sale->inventoryLabItem()->update(['status'=>0,]);
            $reqTrans = ReqTransaction::create($data);

        }

        

        // $sales = $info->sales()->findOrFail($transId);
        // if (!empty($sales)) {
        //     $data = [
        //         'remarks' => $all['remarks'],
        //         'sale_id' => $transId,
        //     ];
        //     $saleDetails = $info->reqTransaction()->create($data);
        // }
        
        session()->flash('success_message', 'Void transaction submitted Successfully.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
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
        Request::validate([
            'status' => 'required|numeric',
        ]);
        $all = Request::all();
        $trans = ReqTransaction::findOrFail($id);
        $result = $trans->update(['status' => $all['status']]);
        if ($all['status'] == 1 ) {
            $trans->sale()->update(['status' => 2]);
        }
        
        
        
        session()->flash('success_message', 'Void transaction updated Successfully.');
        return redirect()->back();
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
