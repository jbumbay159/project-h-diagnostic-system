<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Customer;
use App\Agency;
use App\Package;
use App\Association;
use App\Country;
use App\AgencyPricing;
use App\PricingType;
use App\Sale;
use App\Category;
use App\Service;
use App\LabResult;
use App\ServicePrice;
use Carbon\Carbon;
use App\InventoryLabResultItem;

class CustomerController extends Controller
{
    
    public function __construct()
    {	
        $this->middleware('auth');
    }
    
    public function index()
    {
        $customer = Customer::all();
    	return view('customer.index', compact('customer'));
    }

    public function data()
    {
        $customer = Customer::all();
        return view('customer.index', compact('customer'));   
    }
    
    public function create()
    {
    	$agency = Agency::pluck('name','id');
        $package = Package::pluck('name','id');
        $association = Association::pluck('name','id');
        // $country = Country::pluck('name','id');
        $countryAll = Country::all();
        // dd($agency);
        $country = [];
        if ( count($countryAll) > 0) {
            # code...
            foreach ($countryAll->groupBy('association_id') as $ass => $data) {
                $childData = NULL;
                foreach ($data as $list) {
                    $childData = array_add($childData, $list->id, $list->name);
                }

                $country = array_add($country, Association::findOrFail($ass)->name, $childData);
            }
        }

    	return view('customer.create', compact('agency','package','association','country'));
    }
    
    public function store()
    {
        Request::validate([
            'last_name'     => 'required', 
            'first_name'    => 'required', 
            'gender'        => 'required',
            'birthdate'     => 'required|date',
            'address'       => 'required',
            'package_id'    => 'required|exists:packages,id|numeric',
            'country'    => 'required|exists:countries,id|numeric',
            'agency'     => 'required|exists:agencies,id|numeric',
            'price'         => 'required',
            'remarks'       => 'required',
        ]);
        
        $all = Request::all();
        $barcode = $this->generateBarcodeNumber();
        $all = array_add($all, 'barcode', $barcode);

        $customer = Customer::create($all);
        $customer->country()->attach($all['country']);
        $customer->agency()->attach($all['agency']);

        $package = Package::findOrFail($all['package_id']);
        $saleData = [
            'name' => $package->name,
            'quantity' => 1,
            'unit_price' => $package->price,
            'discount' => $package->price - $all['price'],
            'total_price' => $all['price'],
            'payment_id' => 1,
            'agency_id' => $all['agency'],
            'status' => 0,
            'days' => $package->days - 1,
            'transcode' => $this->generateSaleNumber(),
        ];

        $sale = $customer->sales()->create($saleData);
        $transData = [
            'name' =>  $package->name,
            'customer_id' => $customer->id,
            'agency_id' => $all['agency'],
            'status_id' => 1,
            'status' => 'PENDING',
            
        ];
        // ['FIT TO WORK'=>'FIT TO WORK','RECOMMENDED'=>'RECOMMENDED','UNFIT TO WORK'=>'UNFIT TO WORK','PENDING'=>'PENDING']
        
        // $sale->transmittal()->create($transData);
        foreach ($package->services as $data) {
            
            $serviceData = [
                'customer_id' => $customer->id,
                'name' => $data->name,
                'category_name' => Category::findOrFail($data->category_id)->name,
                'service_id' => $data->id,
            ];
            $labResult = $sale->labResults()->create($serviceData);
            $services = Service::findOrFail($data->id);
            foreach ($services->item as $item) {
                $itemData = [
                    'name' => $item->service, 
                    'group' => $item->group, 
                    'normal_values' => $item->nv, 
                    'co_values' => $item->cov,
                    'remarks' => $item->remarks,
                ];

                $labResult->items()->create($itemData);
            }
            if ($services->supplies()->count() > 0 ) {
                foreach ($services->supplies as $supply) {
                    $supplyData = [
                        'customer_id' => $customer->id,
                        'sale_id' => $sale->id,
                        'lab_result_id' => $labResult->id,
                        'supply_id' => $supply->supply_id,
                        'testqty' => $supply->qty,
                    ];
                    InventoryLabResultItem::create($supplyData);
                }

            }
            

        }

        session()->flash('success_message', 'Customer Created Successfully..');
        return redirect()->action('CustomerController@photo', ['id' => $customer->id]);
    
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

    public function generateBarcodeNumber()
    {
        $randnumber = mt_rand(100000, 999999);
        $dateNow = Carbon::now()->format('Ymd');
        $number = $dateNow.$randnumber;

        $custExist = Customer::where('barcode','=',$number)->exists();
        if ($custExist) {
            return generateBarcodeNumber();
        }
        return $number;
    }


    public function show($id)
    {
        $info = Customer::findOrFail($id);
        $package = Package::all()->pluck('namePrice','id');
        $serviceAll = Service::all();
        $sale = $info->sales()->orderBy('created_at', 'desc')->where('status',0)->sum('total_price');


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
        

        $grandTotal = 0;    
       
        $grandTotal = $sale;
        
        $count = 0;
        foreach ($info->labResults as $labData) {
            if ($labData->items()->count() > 0) {
                foreach ($labData->items as $test) { if ($test->result == NULL) { $count++; } }
            }else{ if ($labData->remarks == NULL) { $count++; } }
            
        }
        
        $service = NULL;
        foreach ($info->labResults as $data ){
            $service = array_add($service, $data->id, $data->name.'('.$data->service->price.')');
        }    
        $balance = $info->sales()->where('status',0)->get();

        $latestSale = $info->sales()->where('days','>',0)->orderBy('created_at','desc')->first();
        $dateNow = Carbon::now();
        // dd($latestSale);
        if ( $latestSale != NULL ) {
            $intDate = Carbon::parse($latestSale->created_at)->diffInDays($dateNow);
            if ($intDate > $latestSale->days) {
                $status = "disabled";
            }else{
                $status = "";
            }
        }else{
            $status = "disabled";
        }
        

        return view('customer.show', compact('info','grandTotal','count','service', 'balance','package','serviceList','latestSale','status'));
        
    }
    
    public function edit($id)
    {
        $info = Customer::findOrFail($id);
        $agency = Agency::pluck('name','id');
        $countryAll = Country::all();
        $country = NULL;
        foreach ($countryAll->groupBy('association_id') as $ass => $data) {
            $childData = NULL;
            foreach ($data as $list) {
                $childData = array_add($childData, $list->id, $list->name);
            }

            $country = array_add($country, Association::findOrFail($ass)->name, $childData);
            //$country = array_add([$data->association->name => [$data->id => $data->name]]);
        }
        return view('customer.edit', compact('info','agency','country'));
    }
    
    public function update($id)
    {
        Request::validate([
            'last_name'     => 'required', 
            'first_name'    => 'required', 
            'gender'        => 'required',
            'birthdate'     => 'required|date',
            'address'       => 'required',
            'contact_number'=> 'required',
            'country'    => 'required|exists:countries,id|numeric',
            'agency'     => 'required|exists:agencies,id|numeric',
            'remarks'       => 'required',
        ]);
        $all = Request::all();
        $info = Customer::findOrFail($id);
        
        $agency = $info->agency()->orderBy('pivot_created_at','desc')->first()->id;
        $country = $info->country()->orderBy('pivot_created_at','desc')->first()->id;
        
        if ( $agency != $all['agency'] ) {
            $info->agency()->attach($all['agency']);
        }
        
        if ( $country != $all['country'] ) {
            $info->country()->attach($all['country']);
        }
        
        $info->update($all);
        
        session()->flash('success_message', 'Customer Updated Successfully..');
        return redirect()->back();
    }
    
        
    public function loadData()
    {
        $agency_id = Request::get('agency_id');
        $package_id = Request::get('package_id');
        $country_id = Request::get('country_id');
        $listArray = [
            ['agency_id','=',$agency_id],
            ['package_id','=',$package_id],
            ['country_id','=',$country_id],
        ];
        $data = AgencyPricing::where($listArray)->get();
        $package = Package::where('id','=',$package_id)->first();
        $agencyPricing[] = [];
        $agencyPricing[] = [ 'package_id' => $package_id,'agency_id' => $agency_id,'pricing_type_id' => 0,'price' => $package->price, 'name' => $package->price.' - Regular', ];
        foreach ($data as $list) {
            $priceType = PricingType::findOrFail($list->pricing_type_id);

            $agencyPricing[] = [
                'package_id' => $list->package_id,
                'agency_id' => $list->agency_id,
                'pricing_type_id' => $list->pricing_type_id,
                'price' => $list->price,
                'name' => $list->price.' - '.$priceType->name, 
            ];
        }

        return $agencyPricing; 
    }
    
    
    
    public function updateRetake($id)
    {
        Request::validate([
            'service' => 'required',
        ]);
        $all = Request::all();
        $info = Customer::findOrFail($id);
        
        $labResult = LabResult::whereIn('id',$all['service'])->get();
        $totalPrice = 0;
        $saleName = "";
        foreach ($labResult as $labs) {
            $totalPrice += $labs->service->price;
            $saleName .= $labs->name.', ';

        }
        $saleData = [
            'name' => 'Retake: '.$saleName ,
            'quantity' => 1,
            'unit_price' => $totalPrice,
            'discount' => 0,
            'total_price' => $totalPrice,
            'payment_id' => 1,
            'agency_id' => $info->agency()->orderBy('pivot_created_at','desc')->first()->id,
            'status' => 0,
        ];
        
        
        $sale = $info->sales()->create($saleData);
        
        foreach ($labResult as $data) {
            
            $serviceData = [
                'customer_id' => $info->id,
                'name' => $data->name,
                'category_name' => $data->category_name,
                'service_id' => $data->service_id,
            ];
            $labResultData = $sale->labResults()->create($serviceData);
            
            foreach ($data->items as $item) {
                $itemData = [
                    'name' => $item->name, 
                    'group' => $item->group, 
                    'normal_values' => $item->normal_values, 
                    'co_values' => $item->co_values,
                    'remarks' => $item->remarks,
                ];

                $labResultData->items()->create($itemData);
            }

            foreach ($data->service->supplies as $supply) {
                $supplyData = [
                    'customer_id' => $info->id,
                    'sale_id' => $sale->id,
                    'lab_result_id' => $data->id,
                    'supply_id' => $supply->supply_id,
                    'testqty' => $supply->qty,
                ];
                InventoryLabResultItem::create($supplyData);
            }
        }


        
        session()->flash('success_message', 'Retake Services Added Successfully..');
        return redirect()->back();
        
    }

    public function addService($id)
    {
        Request::validate([
            'service' => 'required',
        ]);
        $all = Request::all();
        $info = Customer::findOrFail($id);
        $priceData = ServicePrice::whereIn('id',$all['service'])->get();
        
        $totalPrice = 0;
        foreach ($priceData as $value) {
            $serviceList[] = $value->service_id;
            $totalPrice += $value->price;
        }
        
        $labResult = Service::whereIn('id',$serviceList)->get();
        
        $saleName = "";
        foreach ($labResult as $labs) {
            $saleName .= $labs->name.', ';
        }

        $saleData = [
            'name' => $saleName ,
            'quantity' => 1,
            'unit_price' => $totalPrice,
            'discount' => 0,
            'total_price' => $totalPrice,
            'payment_id' => 1,
            'agency_id' => $info->agency()->orderBy('pivot_created_at','desc')->first()->id,
            'status' => 0,
            'transcode' => $this->generateSaleNumber(),
        ];
        
        
        $sale = $info->sales()->create($saleData);
        
        foreach ($labResult as $data) {
            
            $serviceData = [
                'customer_id' => $info->id,
                'name' => $data->name,
                'category_name' => $data->category->name,
                'service_id' => $data->id,
            ];
            $labResultData = $sale->labResults()->create($serviceData);
            
            foreach ($data->item as $item) {
                $itemData = [
                    'name' => $item->service, 
                    'group' => $item->group, 
                    'normal_values' => $item->nv, 
                    'co_values' => $item->cov,
                    'remarks' => $item->remarks,
                ];

                $labResultData->items()->create($itemData);

            }         
            if ($data->supplies()->count() > 0) {
                foreach ($data->supplies as $supply) {
                    $supplyData = [
                        'customer_id' => $info->id,
                        'sale_id' => $sale->id,
                        'lab_result_id' => $labResultData->id,
                        'supply_id' => $supply->supply_id,
                        'testqty' => $supply->qty,
                    ];
                    InventoryLabResultItem::create($supplyData);
                }
            }
            
        }
             
        
        session()->flash('success_message', 'Services Added Successfully..');
        return redirect()->back();
    }

    public function saleInvoice($id)
    {
        $saleID = Request::get('saleID');

        $info = Customer::findOrFail($id);
        
        $sale = $info->sales->where('id',$saleID)->first();


        return view('customer.saleInvoice', compact('info','sale'));
    }
    

    //upgrade packages
    public function upgradePackage($id)
    {
        Request::validate([
            'package' => 'required',
        ]);
        $all = Request::all();

        $info = Customer::findOrFail($id);
        $package = Package::findOrFail($all['package']);
    
        $latestSale = $info->sales()->where(['days','>',0],['status','<',2])->orderBy('created_at','desc')->first();
        $dateNow = Carbon::now();
        $intDate = Carbon::parse($latestSale->created_at)->diffInDays(now());
        if ($intDate > $latestSale->days) {
            $discount = 0;
        }else{
            $discount = $latestSale->total_price;
        }
        $saleData = [
            'name' => 'Upgrade:'.$package->name,
            'quantity' => 1,
            'unit_price' => $package->price,
            'discount' => $discount,
            'total_price' => $package->price - $discount,
            'payment_id' => 1,
            'agency_id' => $info->currentAgency->id,
            'status' => 0,
            'days' => $package->days,
            'transcode' => $this->generateSaleNumber(),
        ];
        $notIncluded = $latestSale->labResults()->pluck('service_id')->toArray();
        $packageServices = $package->services()->whereNotIn('service_id',$notIncluded)->get();
        // $latestSale->labResults()->pluck('name','id')->toArray();
        $sale = $info->sales()->create($saleData);
        foreach ($packageServices as $data) {
            $serviceData = [
                'customer_id' => $info->id,
                'name' => $data->name,
                'category_name' => Category::findOrFail($data->category_id)->name,
                'service_id' => $data->id,
            ];
            $labResult = $sale->labResults()->create($serviceData);
            $services = Service::findOrFail($data->id);
            foreach ($services->item as $item) {
                $itemData = [
                    'name' => $item->service, 
                    'group' => $item->group, 
                    'normal_values' => $item->nv, 
                    'co_values' => $item->cov,
                    'remarks' => $item->remarks,
                ];
                $labResult->items()->create($itemData);
            }

            foreach ($service->supplies as $supply) {
                $supplyData = [
                    'customer_id' => $info->id,
                    'sale_id' => $sale->id,
                    'lab_result_id' => $labResult->id,
                    'supply_id' => $supply->supply_id,
                    'testqty' => $supply->qty,
                ];
                InventoryLabResultItem::create($supplyData);
            }
        }
        session()->flash('success_message', 'Package Upgraded Successfully');
        return redirect()->back();
    }




    public function newPackage($id)
    {
        Request::validate([
            'package_id'    => 'required|exists:packages,id|numeric',
            'price'         => 'required',
        ]);
        
        $all = Request::all();
        $customer = Customer::findOrFail($id);
        $currentAgency = $customer->agency()->orderBy('pivot_created_at','desc')->first();

        $package = Package::findOrFail($all['package_id']);
        $saleData = [
            'name' => $package->name,
            'quantity' => 1,
            'unit_price' => $package->price,
            'discount' => $package->price - $all['price'],
            'total_price' => $all['price'],
            'payment_id' => 1,
            'agency_id' => $currentAgency->id,
            'status' => 0,
            'days' => $package->days,
            'transcode' => $this->generateSaleNumber(),
        ];

        $sale = $customer->sales()->create($saleData);
        
        foreach ($package->services as $data) {
            
            $serviceData = [
                'customer_id' => $customer->id,
                'name' => $data->name,
                'category_name' => Category::findOrFail($data->category_id)->name,
                'service_id' => $data->id,
            ];
            $labResult = $sale->labResults()->create($serviceData);
            $services = Service::findOrFail($data->id);
            foreach ($services->item as $item) {
                $itemData = [
                    'name' => $item->service, 
                    'group' => $item->group, 
                    'normal_values' => $item->nv, 
                    'co_values' => $item->cov,
                    'remarks' => $item->remarks,
                ];

                $labResult->items()->create($itemData);
            }

            foreach ($data->supplies as $supply) {
                $supplyData = [
                    'customer_id' => $info->id,
                    'sale_id' => $sale->id,
                    'lab_result_id' => $labResult->id,
                    'supply_id' => $supply->supply_id,
                    'testqty' => $supply->qty,
                ];
                InventoryLabResultItem::create($supplyData);
            }
        }

        session()->flash('success_message', 'New Package added successfully');
        return redirect()->back();
    }

    















    // this is for the photo Controller

    public function uploadPhoto($id)
    {
        $user = Customer::findOrFail($id);
        if ( $user->photo == '') {
            $photo = Request::file('photo');
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = str_random(10).'.'.$photo_extension;
            $photo->move(public_path().'/img', $photo_name);
            $fileData = [
                'photo' => $photo_name,
            ];
            $user->update($fileData);

        }else{
            $photo = Request::file('photo');
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = $user->photo;
            $photo->move(public_path().'/img', $photo_name);
        }
        
        session()->flash('success_message', 'Photo Save Successfully..');
        return redirect()->action('CustomerController@fingerprint',['id' => $user->id]);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // this is fingerprint section
    public function openFinger($id)
    {
        $customer = Customer::findOrFail($id);
        // $mdbFilename = \App\Setting::where('set_name','=','fingerprint')->first()->name;
        $mdbFilename =  $_SERVER["DOCUMENT_ROOT"]."/hyatt/timekeeper/timekeeper.exe";
        if (file_exists($mdbFilename)) {
            // echo $mdbFilename;
            echo exec($mdbFilename);
        }else{
            echo $mdbFilename;
        }
        
    }
    
    public function photo($id)
    {
        $info = Customer::findOrFail($id);
        return view('customer.photo',compact('info'));
    }
    
    public function photoUpdate($id)
    {
        Request::validate([
            'photo'     => 'required', 
        ]);
        $all = Request::all();
        
        $info = Customer::findOrFail($id);
        $info->update($all);
        
        session()->flash('success_message', 'Photo Save Successfully..');
        return redirect()->action('CustomerController@fingerprint',['id' => $info->id]);
        
    }
    
    public function fingerprint($id)
    {
        $info = Customer::findOrFail($id);
        return view('customer.fingerprint', compact('info'));
    }
    
    public function fingerTable($id)
    {
        $info = Customer::findOrFail($id);
        return view('customer.fingertable', compact('info'));
    }
}
