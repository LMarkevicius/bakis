<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Lunch;
use App\Contact;
use Storage;
use Session;
use Image;
use File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $restaurants = Restaurant::withCount('lunches')->orderBy('lunches_count', 'desc')->get();

      $log = File::get("images/check_lunches_log.txt");

      $exploded = explode("**", $log);
      $last = $exploded[count($exploded) - 1];

      $count['match'] = substr_count($last, "Match");
      $count['exists'] = substr_count($last, "exists");
      $count['updated'] = substr_count($last, "Updated");
      $count['new'] = substr_count($last, "Days");
      $count['error'] = substr_count($last, "Error");

      return view('dashboard.restaurants.index')->withRestaurants($restaurants)->withCount($count);
    }

    public function download() {
      $fetch_log = public_path('images/check_lunches_log.txt');

      return response()->download($fetch_log);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('dashboard.restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (!empty($request->address) || !empty($request->city) || !empty($request->phone)) {
        $this->validate($request, [
          'name'          => 'required|max:255',
          'website'       => 'required|url',
          'logo'          => 'required|image',
          'address'       => 'required|max:255',
          'city'          => 'required|max:255',
          'phone'         => 'required|max:255',
        ]);

        $restaurant = new Restaurant;

        $restaurant->name = $request->name;
        $restaurant->website = $request->website;

        $logo = $request->file('logo');
        $filename = time() . '.' . $logo->getClientOriginalExtension();
        $location = public_path('images/') . $filename;

        Image::make($logo)->save($location);

        $restaurant->logo = $filename;

        $restaurant->save();

        $contact = new Contact;

        $contact->restaurant_id = $restaurant->id;
        $contact->address = $request->address;
        $contact->city = $request->city;
        $contact->phone = $request->phone;

        $contact->save();

      } else {
        $this->validate($request, [
          'name'          => 'required|max:255',
          'website'       => 'required|url',
          'logo'          => 'required|image'
        ]);

        $restaurant = new Restaurant;

        $restaurant->name = $request->name;
        $restaurant->website = $request->website;

        $logo = $request->file('logo');
        $filename = time() . '.' . $logo->getClientOriginalExtension();
        $location = public_path('images/') . $filename;

        Image::make($logo)->save($location);

        $restaurant->logo = $filename;

        $restaurant->save();
      }

      Session::flash('success', 'Jūs sėkmingai pridėjote naują restoraną!');

      return redirect()->route('dashboard.edit', $restaurant->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $restaurant = Restaurant::find($id);
      $lunchesByWeekday = Lunch::where('restaurant_id', $restaurant->id)->get()->groupBy('weekday');

      return view('dashboard.restaurants.edit')->withRestaurant($restaurant)->withLunchesByWeekday($lunchesByWeekday);
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
      $this->validate($request, [
        'name'    => 'required|max:255',
        'website' => 'required|max:255',
        'logo'    => 'sometimes|image'
      ]);

      $restaurant = Restaurant::find($id);

      $restaurant->name = $request->name;
      $restaurant->website = $request->website;

      if ($request->has('logo')) {
        $logo = $request->file('logo');
        $filename = time() . '.' . $logo->getClientOriginalExtension();
        $location = public_path('images/') . $filename;
        Image::make($logo)->save($location);

        $oldFilename = $restaurant->logo;

        $restaurant->logo = $filename;

        Storage::delete($oldFilename);
      }


      $restaurant->save();

      Session::flash('success', 'Jūs sėkmingai atnaujinote restorano duomenis!');

      return redirect()->route('dashboard.edit', $restaurant->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $restaurant = Restaurant::find($id);
      $lunches = Lunch::where('restaurant_id', $id)->get();

      $restaurant->contacts()->delete();

      if ($restaurant->lunches()->count() >= 1) {
        foreach ($lunches as $lunch) {
          if (!empty($lunch->image)) {
            Storage::delete($lunch->image);
          }
          
          if ($lunch->xpaths->count() >= 1) {
            $lunch->xpaths[0]->delete();
          }
        }
      }

      $restaurant->lunches()->delete();
      Storage::delete($restaurant->logo);
      $restaurant->delete();

      Session::flash('success', 'Restoranas buvo sėkmingai pašalintas!');

      return redirect()->route('dashboard.index');
    }
}
