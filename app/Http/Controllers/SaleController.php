<?php

namespace App\Http\Controllers;

use Request;
use App\Customer;
use App\Sale;
use DB;
use App\SaleDiscount;
use Carbon\Carbon;
use App\Service;
use App\ServicePrice;
use App\InventoryLabResultItem;

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
        // Services 
        $serviceAll = Service::get();
        $serviceList = [];

        if ( count($serviceAll) > 0) {

            foreach ($serviceAll as $service) {
                $servicePrice = NULL;    
                foreach ($service->prices as $list) {
                    $servicePrice = array_add($servicePrice, $list->id, $list->priceName);
                }
                $serviceList = array_add($serviceList, $service->name, $servicePrice);
            }

        }


        return view('sale.list', compact('customer','info','grandTotal','trans', 'sales','saleFirst','totalAmount','discount','serviceList'));
    }


    public function addService($trans)
    {
        $all = Request::all();
        $services = ServicePrice::findOrFail($all['service_id']);
        $currentSale = Sale::where('transcode',$trans)->first();
        $info = Customer::findOrFail($currentSale->customer_id);

        $saleData = [
            'name' => $services->service->name ,
            'quantity' => 1,
            'unit_price' => $services->price,
            'discount' => 0,
            'total_price' => $services->price,
            'payment_id' => 1,
            'agency_id' => $info->agency()->orderBy('pivot_created_at','desc')->first()->id,
            'status' => 0,
            'transcode' => $trans,
            'customer_id' => $currentSale->customer_id,
        ];
        
        $sale = Sale::create($saleData);

        $serviceData = [
            'customer_id' => $currentSale->customer_id,
            'name' => $services->service->name,
            'category_name' => $services->service->category->name,
            'service_id' => $services->service->id,
        ];

        $labResultData = $sale->labResults()->create($serviceData);
        
        foreach ($services->service->item as $item) {
            $itemData = [
                'name' => $item->service, 
                'group' => $item->group, 
                'normal_values' => $item->nv, 
                'co_values' => $item->cov,
            ];

            $labResultData->items()->create($itemData);

        }         
        if ($services->service->supplies()->count() > 0) {
            foreach ($services->service->supplies as $supply) {
                $supplyData = [
                    'customer_id' => $currentSale->customer_id,
                    'sale_id' => $sale->id,
                    'lab_result_id' => $labResultData->id,
                    'supply_id' => $supply->supply_id,
                    'testqty' => $supply->qty,
                ];
                InventoryLabResultItem::create($supplyData);
            }
        }

        session()->flash('success_message', 'Service added successfully.');
        return redirect()->back();

    }

}
