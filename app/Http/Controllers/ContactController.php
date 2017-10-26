<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Session;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return $contacts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //validate the request
      $this->validate($request, [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255|max:255',
        'phone' => 'required|max:255'
      ]);

      //store the request
      $contact = new Contact;
      $contact->first_name = $request->first_name;
      $contact->last_name = $request->last_name;
      $contact->phone = $request->phone;
      $contact->save();
      return $contact;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contact = Contact::find($id);
        return $contact;
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
        //
        $this->validate($request, [
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255|max:255',
          'phone' => 'required|max:255'
        ]);

        //store the request
        $contact = Contact::find($id);
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->phone = $request->phone;
        $contact->save();
        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return "success";
    }
}
