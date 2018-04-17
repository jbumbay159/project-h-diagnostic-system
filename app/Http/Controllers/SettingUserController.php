<?php

namespace App\Http\Controllers;

use Request;
use DataTables;
use App\User;
use App\Role;

class SettingUserController extends Controller
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
        $users = User::get();
        $roles = Role::get();
        return view('setting.users.index',compact('users','roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('setting.users.create', compact('roles'));
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
            'fullName'     => 'required', 
            'license_no' => 'required|unique:users', 
            'username' => 'required|unique:users,name',
            'email' => 'required|unique:users',
            'signature' => 'image|mimes:png',
        ]);

        $all = Request::all();
        $passwordText = str_random(6);



        $userData = [
            'fullName' => $all['fullName'],
            'license_no' => $all['license_no'],
            'position' => $all['position'],
            'name' => $all['username'],
            'email' => $all['email'],
            'password' => bcrypt($passwordText),
        ];

        $user = User::create($userData);

        $photo = Request::file('signature');
        if ($photo != null) {
            $photo_extension = $photo->getClientOriginalExtension();
            $photo_name = $user->id.'.'.$photo_extension;
            $photo->move(public_path().'/signature', $photo_name);
        }
        

        session()->flash('success_message', 'User Created Successfully.. Password: '.$passwordText);
        return redirect()->action('SettingUserController@edit',$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::get();
        $user = User::findOrFail($id);
        $signature = asset('public/signature/'.$user->id.'.png');
        return view('setting.users.edit', compact('roles','user','signature'));
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
        $all = Request::all();

        $user = User::findOrFail($id);
        $user->update($all);


        session()->flash('success_message', 'User Updated Successfully'); 
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}