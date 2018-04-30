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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($restaurant_id)
    {
      return view('dashboard.contacts.create')->withRestaurantId($restaurant_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $restaurant_id)
    {
      $this->validate($request, [
        'address'   => 'required|max:255',
        'city'   => 'required|max:255',
        'phone'   => 'required|max:255'
      ]);

      $contact = new Contact;

      $contact->restaurant_id = $restaurant_id;
      $contact->address = $request->address;
      $contact->city = $request->city;
      $contact->phone = $request->phone;

      $contact->save();

      Session::flash('success', 'You have successfully added contact!');

      return redirect()->route('dashboard.edit', $restaurant_id);
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
    public function edit($restaurant_id, $id)
    {
      $contact = Contact::find($id);

      return view('dashboard.contacts.edit')->withContact($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurant_id, $id)
    {
      $this->validate($request, [
        'address' => 'required|max:255',
        'city'    => 'required|max:255',
        'phone'   => 'required|max:255'
      ]);

      $contact = Contact::find($id);

      $contact->address = $request->address;
      $contact->city = $request->city;
      $contact->phone = $request->phone;

      $contact->save();

      Session::flash('success', 'You have successfully updated restaurant contact!');

      return redirect()->route('dashboard.edit', $restaurant_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurant_id, $id)
    {
      $contact = Contact::find($id);

      $contact->delete();

      Session::flash('success', 'You have successfully deleted contact!');

      return redirect()->route('dashboard.edit', $restaurant_id);
    }
}
