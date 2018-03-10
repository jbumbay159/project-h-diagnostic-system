<?php

namespace App\Http\Controllers;

use Request;
use App\Country;
use App\Association;

class CountryController extends Controller
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
        $country = Country::get();
        return view('country.index', compact('country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $association = Association::pluck('name','id');
        return view('country.create', compact('association'));
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
            'name' => 'required|unique:countries',
            'association_id' => 'required|exists:associations,id|numeric',
        ]);
        
        $all = Request::all();
        $country = Country::create($all);
        
        session()->flash('success_message', 'Country Created Successfully..');
        return redirect()->action('CountryController@edit', ['id' => $country->id]);
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $association = Association::pluck('name','id');
        
        return view('country.edit', compact('country','association'));
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
            'name' => 'required|unique:countries,name,'.$id,
            'association_id' => 'required|exists:associations,id|numeric',
            
        ]);
        
        $all = Request::all();
        $country = Country::findOrFail($id);
        $result = $country->update($all);
        
        
        session()->flash('success_message', 'Country Updated Successfully..');
        return redirect()->back();
    }

    
}
