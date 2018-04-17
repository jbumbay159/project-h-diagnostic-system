<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Sale;
use App\Agency;
use App\Transmittal;
use App\SaleDiscount;
use App\LabResult;
use App\LabResultItem;
use App\Country;
use App\Customer;
use App\XrayResult;
use App\Vaccine;
use App\InventoryLabResultItem;

class ReportController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth');
    }
	
    public function dailySalesReport()
    {
    	
    	if ( Request::get('date_from') != NULL AND Request::get('date_to') != NULL ) {
    		$date_from = Request::get('date_from');
		    $date_to = Request::get('date_to');

		    $salesPayment = Sale::where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->orderBy('created_at')->get()->groupBy('transcode');
            $billedPayment = Sale::where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->orderBy('created_at')->get()->groupBy('transcode');

		    return view('report.saleDailyResult', compact('salesPayment','billedPayment','date_from','date_to'));
    	}else{
    		return view('report.saleDaily');	
    	}
    	
    }
    
    public function agencySalesReport()
    {
    	if ( Request::get('date_from') != NULL AND Request::get('date_to') != NULL ) {
            $date_from = Request::get('date_from');
            $date_to = Request::get('date_to');

            $agency = Agency::all();   
            
            return view('report.saleAgencyResult', compact('agency','date_from','date_to'));
        }else{
            return view('report.saleAgency');    
        }
    }
    
    public function summarySalesReport()
    {
        if ( Request::get('date_from') != NULL AND Request::get('date_to') != NULL ) {
            $date_from = Request::get('date_from');
            $date_to = Request::get('date_to');
            $cashTotal = 0;
            $creditTotal = 0;
            $sales = Sale::whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('transcode');  
            foreach ($sales as $transcode => $salesData) {
                $saleDiscount = SaleDiscount::where('transcode',$transcode)->first();
                if ($saleDiscount != NULL) {
                    $discount = $saleDiscount->amount;
                }else{
                    $discount = 0;
                }
                foreach ($salesData as $data) {
                    if ($data->payment_id == 1) {
                        $cashTotal +=($data->total_price - $discount);
                    }else{
                        $creditTotal +=($data->total_price - $discount);
                    }
                }
                
            }
            
            $total = $cashTotal + $creditTotal;
            
            $summary = ['cash' => $cashTotal, 'credit' => $creditTotal, 'total' => $total];
            
            
            return view('report.saleSummaryResult', compact('summary','date_from','date_to','sale'));
        }else{
            return view('report.saleSummary');    
        }
    }
    
    public function transactionSummaryReport()
    {
        $packages = 0;
        $services = 0;
        $associations = 0;
        $xray = 0;
        $ecg = 0;
        $vaccine = 0;

        if (Request::get('date_from') != NULL AND Request::get('date_to') != NULL) {
            $dateFrom = Request::get('date_from');
            $dateTo = Request::get('date_to');

            $date_from = Carbon::parse($dateFrom)->toFormattedDateString();
            $date_to = Carbon::parse($dateTo)->toFormattedDateString();

            $customers = Customer::get();
            foreach ($customers as $customer) {
                $associations += count($customer->country()->whereDate('pivot_created_at','>=',$dateFrom)->whereDate('pivot_created_at','<=',$dateTo));
            }

            $packages = LabResult::whereDate('created_at','>=',$dateFrom)->whereDate('created_at','<=',$dateTo)->count();
            $services = LabResultItem::whereDate('updated_at','>=',$dateFrom)->whereDate('updated_at','<=',$dateTo)->count();
            $xray = XrayResult::whereDate('created_at','>=',$dateFrom)->whereDate('created_at','<=',$dateTo)->count();
            $ecg = LabResult::where('name','=','ecg')->whereDate('updated_at','>=',$dateFrom)->whereDate('updated_at','<=',$dateTo)->count();
            $vaccine = Vaccine::whereDate('created_at','>=',$dateFrom)->whereDate('created_at','<=',$dateTo)->count();

            return view('report.transactionSummaryResult', compact('associations','packages','services','xray','ecg','vaccine','date_from','date_to'));
        }else{
            return view('report.transactionSummary');

        }
        
        
        
    }

    public function statusReport()
    {
        $agencies = Agency::pluck('name','id');
        $dateNow = Carbon::now()->toDateString();
        $date_from = NULL;
        $date_to = NULL;

        $status = [
            7=>'PENDING',
            1=>'FIT TO WORK',
            2=>'UNFIT TO WORK',
            3=>'RECOMMENDED',
            4=>'NOT RECOMMENDED',
            5=>'FOR MMR VACCINE',
            6=>'MMR VACCINE',
        ];

        // if (condition) {
        //     # code...
        // }


        $trasmittalStatus = new Transmittal;

        if (Request::get('date_from') != NULL) {
            $trasmittalStatus = $trasmittalStatus->whereDate('encode_date','>=',Request::get('date_from'));
            $date_from = Carbon::parse(Request::get('date_from'))->toFormattedDateString();
        }
        if (Request::get('date_to') != NULL) {
            $trasmittalStatus = $trasmittalStatus->whereDate('encode_date','<=',Request::get('date_to'));
            $date_to = Carbon::parse(Request::get('date_to'))->toFormattedDateString();
        }
        if (Request::get('agency') != NULL) {
            $trasmittalStatus = $trasmittalStatus->where('agency_id',Request::get('agency'));
        }
        if (Request::get('status') != NULL) {
            $trasmittalStatus = $trasmittalStatus->where('status_id',Request::get('status'));
        }

        $trasmittalStatus = $trasmittalStatus->get();

        if (Request::get('print') != NULL) {
            return view('report.statusResult', compact('agencies','status','dateNow','trasmittalStatus','date_to','date_from'));
        }else{
            return view('report.status', compact('agencies','status','dateNow','trasmittalStatus'));
        }
    }

    public function consumedProd()
    {
        $date_from = NULL;
        $date_to = NULL;

        $items = new InventoryLabResultItem;
        if (Request::get('date_from') != NULL) {
            $items = $items->whereDate('created_at','>=',Request::get('date_from'));
            $date_from = Carbon::parse(Request::get('date_from'))->toFormattedDateString();
        }
        if (Request::get('date_to') != NULL) {
            $items = $items->whereDate('created_at','<=',Request::get('date_to'));
            $date_to = Carbon::parse(Request::get('date_to'))->toFormattedDateString();
        }
        $items = $items->where('status',1)->get();

        if (Request::get('print') != NULL) {
            return view('report.consumedProdResult',compact('items','date_from','date_to'));
        }else{
            return view('report.consumedProd',compact('items'));    
        }
        
    }
}
