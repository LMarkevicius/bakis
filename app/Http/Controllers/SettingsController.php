<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use Session;

class SettingsController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $settings = Settings::find(1);

      return view('dashboard.settings.edit')->withSettings($settings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request, [
        'sleep'   => 'required|numeric',
        'daily'   => 'required_without:hourly',
        'hourly'  => 'required_without:daily'
      ]);

      $settings = Settings::find(1);

      $settings->sleep = $request->sleep;

      if ($request->daily) {
        $settings->daily = $request->daily;
        $settings->hourly = NULL;
      }

      if ($request->hourly) {
        $settings->hourly = $request->hourly;
        $settings->daily = NULL;
      }

      $settings->save();

      Session::flash('success', 'Jūs sėkmingai atnaujinote nustatymus!');

      return redirect()->route('settings.edit');
    }
}
