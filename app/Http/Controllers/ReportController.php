<?php

namespace App\Http\Controllers;

use Request;
use App\Sale;
use App\Agency;
use App\Transmittal;
use App\SaleDiscount;

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

		    $salesPayment = Sale::where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('transcode');
            $billedPayment = Sale::where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('transcode');
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

        $transmittal = NULL;
        if ( Request::get('date_from') != NULL AND Request::get('date_to') != NULL ) {
            $date_from = Request::get('date_from');
            $date_to =  Request::get('date_to');

            $transmittal = Transmittal::whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('agencyName');   
            $dateExist = true;
        }else{
            $date_from = NULL;
            $date_to =  NULL;
            $dateExist = false;
        }
        return view('report.transactionSummary', compact('dateExist','transmittal','date_from','date_to'));
    }
}
