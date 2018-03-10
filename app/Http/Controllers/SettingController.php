<?php

namespace App\Http\Controllers;

use Request;
use App\Setting;

class SettingController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
    }

    public function index()
    {
    	$allSettings = Setting::get();
    	$settings = NULL;
    	foreach ($allSettings as $set) {
    		$settings = array_add($settings,$set->set_name, $set->name);
    	}

    	if (Request::get('tab') != NULL AND Request::get('tab') == 'vaccine') {
    		return view('setting.vaccine', compact('settings'));
    	}else{
    		return view('setting.index', compact('settings'));	
    	}
    	
    }

    public function store()
    {
    	$all = Request::all();
    	foreach ($all as $set_name => $name) {
    		Setting::updateOrCreate(['set_name'=>$set_name],['name'=>$name]);
    	}

    	session()->flash('success_message', 'Setting updated successfully');
        return redirect()->back();
    }
}
