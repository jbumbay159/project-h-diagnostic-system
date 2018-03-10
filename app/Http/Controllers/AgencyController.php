<?php

namespace App\Http\Controllers;

use Request;
use App\Agency;

class AgencyController extends Controller
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
        $agency = Agency::all();
        return view('agency.index', compact('agency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agency.create');
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
            'name' => 'required|unique:agencies',
            'address' => 'required',
            'email.*' => 'required|email',
            'contact_person' => 'required',
            'contact.*' => 'required',
        ],[
           'email.*.email'     =>      'Please input valid email address.' ,
        ]);
        $all = Request::all();

        $agency = Agency::create(Request::all());

        // for emails
        if (isset($all['email'])) {
            $emailData = NULL;
            foreach ($all['email'] as $emailValue) {
                $emailData[] = ['email'=>$emailValue];
            }
            $agency->emailAddress()->delete();
            $agency->emailAddress()->createMany($emailData);
        }else{
            $agency->emailAddress()->delete();
        }

        // for contact number
        if (isset($all['contact'])) {
            $contact = NULL;
            foreach ($all['contact'] as $contactValue) {
                $contact[] = ['contact'=>$contactValue];
            }
            $agency->contacts()->delete();
            $agency->contacts()->createMany($contact);
        }else{
            $agency->contacts()->delete();
        }
        
        session()->flash('success_message', 'Agency Created Successfully..');
        return redirect()->action('AgencyController@edit', ['id' => $agency->id]);
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
        $agency = Agency::findOrFail($id);
        $emails = $agency->emailAddress()->pluck('email','email');
        $contacts = $agency->contacts()->pluck('contact','contact');
        return view('agency.edit', compact('agency','emails','contacts'));
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
        Request::validate([
            'name' => 'required|unique:agencies,name,'.$id,
            'address' => 'required',
            'email.*' => 'required|email',
            'contact_person' => 'required',
            'contact.*' => 'required',
        ],[
           'email.*.email'     =>      'Please input valid email address.' ,
        ]);
        
        
        // dd($emailData); 
        $agency = Agency::findOrFail($id);
        $result = $agency->update($all);
        
        // for emails
        if (isset($all['email'])) {
            $emailData = NULL;
            foreach ($all['email'] as $emailValue) {
                $emailData[] = ['email'=>$emailValue];
            }
            $agency->emailAddress()->delete();
            $agency->emailAddress()->createMany($emailData);
        }else{
            $agency->emailAddress()->delete();
        }

        // for contact number
        if (isset($all['contact'])) {
            $contact = NULL;
            foreach ($all['contact'] as $contactValue) {
                $contact[] = ['contact'=>$contactValue];
            }
            $agency->contacts()->delete();
            $agency->contacts()->createMany($contact);
        }else{
            $agency->contacts()->delete();
        }
        
        session()->flash('success_message', 'Agency Updated Successfully..');
        return redirect()->back();
    }

}
