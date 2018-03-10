<?php

namespace App\Http\Controllers;

use Request;
use App\Category;

class CategoryController extends Controller
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
        $category = Category::all();
        return view('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'name' => 'required|unique:categories',
        ]);
        $category = Category::create(Request::all());
        session()->flash('success_message', 'Caategory Created Successfully..');
        return redirect()->action('CategoryController@edit', ['id' => $category->id]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));  
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
            'name' => 'required|unique:categories,name,'.$id,
        ]);
        $category = Category::findOrFail($id);
        $result = $category->update(Request::all());
        session()->flash('success_message', 'Category Updated Successfully..');
        return redirect()->back();
        
    }


}
