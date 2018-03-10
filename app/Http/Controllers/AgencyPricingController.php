<?php

namespace App\Http\Controllers;

use Request;
use App\AgencyPricing;
use App\Package;
use App\Agency;
use App\PricingType;
use App\Country;
use App\Association;
use DB;


class AgencyPricingController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }
    
    public function index()
    {
    	if ( Request::get('package') != NULL AND Request::get('agency') != NULL ) {
			$agencyPricing = AgencyPricing::where([['agency_id','=', Request::get('agency')], ['package_id','=',Request::get('package')]])->get();
    	}elseif (Request::get('package') != NULL AND Request::get('agency') == NULL) {
    		$agencyPricing = AgencyPricing::where('package_id',Request::get('package'))->get();
    	}elseif (Request::get('package') == NULL AND Request::get('agency') != NULL) {
    		$agencyPricing = AgencyPricing::where('agency_id',Request::get('agency'))->get();    		
    	}else{
    		$agencyPricing = AgencyPricing::all();
    	}
        $package = Package::pluck('name','id');
        $agency = Agency::pluck('name','id');
        return view('agency-pricing.index', compact('agencyPricing','package','agency'));
    }


    public function create()
    {
    	$package = Package::all()->pluck('namePrice','id');
        $agency = Agency::pluck('name','id');
        $pricingType = PricingType::pluck('name','id');

        $countryAll = Country::all();
        // dd($agency);
        $country = NULL;
        if ( count($countryAll) > 0) {
            # code...
            
            foreach ($countryAll->groupBy('association_id') as $ass => $data) {
                $childData = NULL;
                foreach ($data as $list) {
                    $childData = array_add($childData, $list->id, $list->name);
                }

                $country = array_add($country, Association::findOrFail($ass)->name, $childData);
                //$country = array_add([$data->association->name => [$data->id => $data->name]]);
            }
        }

    	return view('agency-pricing.create', compact('package', 'agency','pricingType','country'));
    }

    public function store()
    {

    	Request::validate([
            'package_id' => 'required|exists:packages,id|numeric',
            'agency_id' => 'required|exists:agencies,id|numeric',
            'pricing_type_id' => 'required|exists:pricing_types,id|numeric',
            'country_id' => 'required|exists:countries,id|numeric',
            'price' => 'required|numeric',
        ]);

        $all = Request::all();
        $dataId = [
            'package_id' => $all['package_id'], 
            'agency_id' => $all['agency_id'], 
            'pricing_type_id' => $all['pricing_type_id'],
            'country_id' => $all['country_id']
        ];

        $agencypricing = AgencyPricing::updateOrCreate($dataId,['price' => $all['price']]);
        
        session()->flash('success_message', 'Agency Pricing Created Successfully..');
        return redirect()->action('AgencyPricingController@edit', ['id' => $agencypricing->id]);
    }


    public function edit($id)
    {
        $agencyPricing = AgencyPricing::findOrFail($id);

    	$package = Package::select(DB::raw("concat(name,' - (',price,')') AS name"), 'id')->pluck('name','id');
        $agency = Agency::pluck('name','id');
        $pricingType = PricingType::pluck('name','id');

        $countryAll = Country::all();
        // dd($agency);
        $country = NULL;
        if ( count($countryAll) > 0) {
            # code...
            
            foreach ($countryAll->groupBy('association_id') as $ass => $data) {
                $childData = NULL;
                foreach ($data as $list) {
                    $childData = array_add($childData, $list->id, $list->name);
                }

                $country = array_add($country, Association::findOrFail($ass)->name, $childData);
                //$country = array_add([$data->association->name => [$data->id => $data->name]]);
            }
        }

        return view('agency-pricing.edit', compact('agencyPricing','package', 'agency','pricingType','country'));
    }

    public function update($id)
    {
    	Request::validate([
            'package_id' => 'required|exists:packages,id|numeric',
            'agency_id' => 'required|exists:agencies,id|numeric',
            'pricing_type_id' => 'required|exists:pricing_types,id|numeric',
            'country_id' => 'required|exists:countries,id|numeric',
            'price' => 'required|numeric',
        ]);

        $all = Request::all();
        // $agencypricing = AgencyPricing::create($all);
        $dataId = [
            'package_id' => $all['package_id'], 
            'agency_id' => $all['agency_id'], 
            'pricing_type_id' => $all['pricing_type_id'],
            'country_id' => $all['country_id']
        ];

        $agencypricing = AgencyPricing::updateOrCreate($dataId,['price' => $all['price']]);
        
        session()->flash('success_message', 'Agency Pricing Updated Successfully..');
        return redirect()->back();
    }

    public function destroy($id){
        $agency = AgencyPricing::findOrFail($id)->delete();

        session()->flash('success_message', 'Agency Pricing Deleted Successfully..');
        return redirect()->back();
    }
}
