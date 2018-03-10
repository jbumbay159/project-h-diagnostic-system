<?php

namespace App\Http\Controllers;

use Request;
use App\Service;
use App\Service_item;
use App\Category; 
use App\Supply;
use Carbon\Carbon;

class ServiceController extends Controller
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
        $service = Service::all();
        return view('service.index', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id');
        $supply = Supply::pluck('name','id');
        return view('service.create',compact('categories','supply'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Request::validate([
            'name' => 'required|unique:services',
            'category_id' => 'required|exists:categories,id|numeric',
            'price.*' => 'required|numeric',
        ]);

        $service = Service::create(Request::all());

        if (Request::get('price') !== NULL) {
            $price = NULL;
            foreach (Request::get('price') as $priceValue) {
                $price[] = ['price'=>$priceValue];
            }
            $service->prices()->delete();
            $service->prices()->createMany($price);
        }else{
            $service->prices()->delete();
        }

        if (Request::get('is_xray') == NULL) {
            foreach(Request::get('service') as $key => $value){
                if (!empty($value)) {
                    $data = [
                        'service_id'        =>      $service->id,
                        'service'           =>      $value,
                        'cov'               =>      Request::get('cov')[$key],
                        'nv'                =>      Request::get('nv')[$key],
                        'group'             =>      Request::get('group')[$key],
                    ];
                    Service_item::create($data);
                }
            }  
        }

        $suppIds[] = "";
        if (Request::get('supplies') != NULL AND !empty($all['supply_id']) ) {
            foreach ($all['supply_id'] as $suppKey => $suppValue) {
                $service->supplies()->updateOrCreate(['supply_id'=>$suppValue],['qty'=>$all['test'][$suppKey]]);
                $suppIds[] = $suppValue;
            }

        }
        $service->supplies()->whereNotIn('supply_id', $suppIds)->delete();
        
        
        session()->flash('success_message', 'Service Created Successfully..');
        return redirect()->action('ServiceController@edit', ['id' => $service->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::pluck('name','id');
        $service = Service::findOrFail($id);
        $take_first = $service->item()->first();
        $price = $service->prices()->pluck('price','price');
        $supply = Supply::pluck('name','id');
        
        return view('service.edit', compact('service','categories','take_first','price','supply'));
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
            'name' => 'required|unique:services,name,'.$id,
            'category_id' => 'required|exists:categories,id|numeric',
            'price.*' => 'required|numeric',
        ]);
        $all = Request::all();
        if (Request::get('is_xray') == NULL ) {
            $xrayVar = 0;
        }else{
            $xrayVar = 1;
        }

        $service = Service::findOrFail($id);
        $result = $service->update(['name' => $all['name'], 'category_id' => $all['category_id'],'is_xray'=>$xrayVar]);
        if (isset($all['price'])) {
            $contact = NULL;
            foreach ($all['price'] as $priceValue) {
                $price[] = ['price'=>$priceValue];
            }
            $service->prices()->delete();
            $service->prices()->createMany($price);
        }else{
            $service->prices()->delete();
        }
        
        $ids[] = "";
        if (!empty($all['id']) AND $xrayVar == 0 ) {
            foreach ($all['id'] as $key => $value) {
                $data = [
                    'service'           =>      $all['service'][$key],
                    'cov'               =>      $all['cov'][$key],
                    'nv'                =>      $all['nv'][$key],
                    'group'                =>      $all['group'][$key],
                ];
                if ($value == "no") {
                    $item_id = $service->item()->create($data)->id;
                    $ids[] = $item_id;
                }else{
                    $item = Service_item::findOrFail($value);
                    $item->update($data);
                    $ids[] = $value;
                }
            }
        }
        $suppIds[] = "";
        if (Request::get('supplies') != NULL AND !empty($all['supply_id']) ) {
            foreach ($all['supply_id'] as $suppKey => $suppValue) {
                $service->supplies()->updateOrCreate(['supply_id'=>$suppValue],['qty'=>$all['test'][$suppKey]]);
                $suppIds[] = $suppValue;
            }

        }
        $service->supplies()->whereNotIn('supply_id', $suppIds)->delete();

        
        $service->item()->whereNotIn('id', $ids)->delete();
        
        session()->flash('success_message', 'Service Updated Successfully..');
        return redirect()->back();
        
    }


     public function print($id)
    {
        $categories = Category::pluck('name','id');
        $service = Service::findOrFail($id);
        $take_first = $service->item()->first();
        $price = $service->prices()->pluck('price','price');
        $supply = Supply::pluck('name','id');
        $dateNow = Carbon::now()->format('n/d/Y');
        
        return view('service.print', compact('service','categories','take_first','price','supply','dateNow'));
    }
}
