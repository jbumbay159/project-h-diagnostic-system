<?php

namespace App\Http\Controllers;

use Request;
use App\Sale;
use App\Agency;
use App\Transmittal;

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

		    $sales = Sale::whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get();	
		    
		    return view('report.saleDailyResult', compact('sales','date_from','date_to'));
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
            $sales = Sale::whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get();  
            foreach ($sales as $data) {
                if ($data->payment_id == 1) {
                    $cashTotal +=$data->total_price;
                }else{
                    $creditTotal +=$data->total_price;
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
