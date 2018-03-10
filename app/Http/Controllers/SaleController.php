<?php

namespace App\Http\Controllers;

use Request;
use App\Customer;
use App\Sale;
use DB;
use App\SaleDiscount;
use Carbon\Carbon;

class SaleController extends Controller
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
        $customer = Customer::all()->pluck('fullName', 'id');
        return view('sale.index', compact('customer'));
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
        return redirect()->action('SaleController@show', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Customer::with(['sales','payments','agency','transmittal'])->findOrFail($id);
        //dd($info);
        
        $customer = Customer::get()->pluck('fullName', 'id');
        $sale = $info->sales()->orderBy('created_at', 'desc')->get();
        $grandTotal = 0;    
        foreach ( $sale as $item ){
            $grandTotal += $item->total_price;
        }
        $totalPay = 0;
        foreach ($info->payments as $payList) {
            $totalPay += $payList->amount;
        }

        $grandTotal = $grandTotal - $totalPay;


        $info = array_add($info, 'agencyName', $info->agency()->orderBy('created_at','desc')->first()->name);
        $trans = $info->transmittal()->orderBy('encode_date','DESC')->first();
        return view('sale.show', compact('customer','info','grandTotal','trans'));
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
        $sale = Sale::findOrFail($id);
        $all = Request::all();
        if (isset($all['payment_id'])) {
            if ($all['payment_id'] == 1) {
                $saleData = [
                    'customer_id' => $sale->customer_id,
                    'amount' => $sale->total_price,
                    'payment_id' => $all['payment_id'],
                ];
                $amount = $sale->payments()->create($saleData);
                $all = array_add($all, 'status', 1);
            }else{
                $all = array_add($all, 'status', 2);
            }
        }else{
            if (isset($all['discount'])) {
                $total_price =   $sale->unit_price - $all['discount'];
                $all = array_add($all, 'total_price', $total_price);
            }elseif (isset($all['quantity'])){ 
                $total_price =   ($sale->unit_price * $all['quantity']) - $sale->discount;
                $all = array_add($all, 'total_price', $total_price);
            }
        }

        $sale->update($all);

        $sale->inventoryLabItem()->update(['status'=>1,]);
        session()->flash('success_message', 'Sale Updated Successfully.');
        return redirect()->back();
    }

    public function acceptPayment($trans='')
    {
        $sales = Sale::where('transcode',$trans);
        $all = Request::all();
        foreach ($sales->get() as $sale) {
            $saleData = [
                'customer_id' => $sale->customer_id,
                'amount' => $sale->total_price,
                'payment_id' => $all['payment_id'],
            ];
            $sale->payments()->create($saleData);
            $sale->inventoryLabItem()->update(['status'=>1,]);
        }

        if ($all['payment_id'] == 1) {
            $status = 1;
        }else{
            $status = 2;
        }

        $sales->update(['payment_id'=>$all['payment_id'],'status'=>$status]);
        session()->flash('success_message', 'Payment updated successfully.');
        return redirect()->back();
    }


    public function discount($trans)
    {
        $all = Request::all();

        SaleDiscount::updateOrCreate(['transcode'=>$trans],$all);
        session()->flash('success_message', 'Discount updated successfully.');
        return redirect()->back();
    }


    public function printPayment($trans)
    {
        $sale = Sale::where('transcode', $trans)->first();
        $transList = Sale::where('transcode', $trans)->get();
        $totalAmount = 0;
        $info = [
            'Transaction No.' => $trans,
            'Name' => $sale->customer->fullName,
            'Date' => Carbon::parse($sale->created_at)->toFormattedDateString(),
        ];

        $discount = 0;
        $saleDiscount = SaleDiscount::where('transcode',$trans)->first();
        
        if ( $saleDiscount != NULL ) {
            $discount = $saleDiscount->amount;
        }

        

        return view('sale.print',compact('info','transList','sale','totalAmount','discount'));
    }

    public function voidSales($id)
    {
        Request::validate([
            'transaction.*' => 'required|exists:sales,id|numeric',
            'remarks' => 'required',
        ],[
           'transaction.*.exists'     =>      "Transaction didn't exist" ,
        ]);
        $all = Request::all();
        $info = Customer::findOrFail($id);
        foreach ($all['transaction'] as $transId) {

            $data = [
                'remarks' => $all['remarks'],
                'sale_id' => $transId,
            ];
            // dd($data);
            $saleDetails = $info->reqTransaction()->create($data);
        }
        
        session()->flash('success_message', 'Void transaction submitted Successfully.');
        return redirect()->back();
    }

    public function generateSaleNumber()
    {
        $randnumber = mt_rand(100000, 999999);
        $dateNow = Carbon::now()->format('Ymd');
        $number = $dateNow.$randnumber;

        $custExist = Sale::where('transcode','=',$number)->exists();
        if ($custExist) {
            return generateSaleNumber();
        }
        return $number;
    }


    public function list($id, $trans)
    {
        $info = Customer::findOrFail($id);
        $sale = Sale::where('transcode', $trans)->get();
        $discount = 0;
        $saleDiscount = SaleDiscount::where('transcode',$trans)->first();
        
        if ( $saleDiscount != NULL ) {
            $discount = $saleDiscount->amount;
        }


        $info = Customer::with(['sales','payments','agency','transmittal'])->findOrFail($id);
        //dd($info);
        
        $customer = Customer::get()->pluck('fullName', 'id');
        $sales = $info->sales()->where('transcode', $trans)->get();
        $saleFirst = $info->sales()->where('transcode', $trans)->first();
        $grandTotal = 0;    
        foreach ( $sale as $item ){
            $grandTotal += $item->total_price;
        }
        $totalPay = 0;
        foreach ($info->payments as $payList) {
            $totalPay += $payList->amount;
        }

        $grandTotal = $grandTotal - $totalPay;
        $totalAmount = $info->sales()->where('transcode', $trans)->sum('total_price') - $discount;

        $info = array_add($info, 'agencyName', $info->agency()->orderBy('created_at','desc')->first()->name);   

        // dd($sale);

        return view('sale.list', compact('customer','info','grandTotal','trans', 'sales','saleFirst','totalAmount','discount'));
    }

}
