<?php

namespace App\Http\Controllers;

use Request;
use App\PricingType;


class PricingTypeController extends Controller
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
        $typelist = PricingType::all();
        return view('pricing-type.index', compact('typelist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pricing-type.create', compact('typelist'));
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
            'name' => 'required|max:255',
        ]);
        $all = Request::all();
        
        $pricingType = PricingType::create($all);
        
        session()->flash('success_message', 'Pricing Type Created Successfully..');
        return redirect()->action('PricingTypeController@edit', ['id' => $pricingType->id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pricingtype = PricingType::findOrFail($id);
        return view('pricing-type.edit',compact('pricingtype'));
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
            'name' => 'required|max:255',
        ]);
        $all = Request::all();
        $pricingType = PricingType::findOrFail($id);
        $pricingType->update($all);
        
        session()->flash('success_message', 'Pricing Type Updated Successfully..');
        return redirect()->back();
    }

}
