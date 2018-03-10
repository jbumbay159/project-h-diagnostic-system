<?php

namespace App\Http\Controllers;

use Request;
use App\Association;

class AssociationController extends Controller
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
        $association = Association::all();
        return view('association.index', compact('association'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('association.create');
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
            'name' => 'required|unique:associations',
        ]);
        
        $association = Association::create(Request::all());
        session()->flash('success_message', 'Association Created Successfully..');
        return redirect()->action('AssociationController@edit', ['id' => $association->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $association = Association::findOrFail($id);
        return view('association.edit', compact('association'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Request::validate([
            'name' => 'required|unique:associations,name,'.$id,
        ]);
        
        
        $association = Association::findOrFail($id);
        $association->update(Request::all());
        
        session()->flash('success_message', 'Association Updated Successfully..');
        return redirect()->back();
    }

    
}
