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

      // $log = File::get("images/check_lunches_log.txt");
      //
      // $exploded = explode("**", $log);
      // $last = $exploded[count($exploded) - 1];
      // // dd($last);
      // $count = substr_count($last, "Match");

      // dd($count);
      // asdasdasdasd
      return view('dashboard.restaurants.index')->withRestaurants($restaurants);
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
          'website'       => 'required|max:255',
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

        // switch ($request->count_deals) {
        //   case 1:
        //     $this->validate($request, [
        //       'address'       => 'required|max:255',
        //       'city'          => 'required|max:255',
        //       'phone'         => 'required|max:255',
        //       'title.0'         => 'required|max:255',
        //       'image.0'         => 'sometimes',
        //       'price.0'         => 'required',
        //       'weekday.0'       => 'required|max:255'
        //     ]);
        //
        //     $lunch = new Lunch;
        //
        //     $lunch->restaurant_id = $restaurant->id;
        //     $lunch->title = $request->title[0];
        //     $lunch->price = $request->price[0];
        //     $lunch->weekday = $request->weekday[0];
        //
        //     if ($request->hasFile('image')) {
        //       $image = $request->file('image')[0];
        //       $filename = time() . '.' . $image->getClientOriginalExtension();
        //       $location = public_path('images/') . $filename;
        //
        //       Image::make($image)->save($location);
        //
        //       $lunch->image = $filename;
        //     } else {
        //       $lunch->image = 'placeholder.jpg';
        //     }
        //
        //     $lunch->save();
        //
        //     break;
        //   default:
        //     // dd('OPA')
        //     for ($i = 0; $i < $request->count_deals; $i++) {
        //       $this->validate($request, [
        //         'address'       => 'required|max:255',
        //         'city'          => 'required|max:255',
        //         'phone'         => 'required|max:255',
        //         "title.$i"         => 'required|max:255',
        //         "image.$i"         => 'sometimes',
        //         "price.$i"         => 'required',
        //         "weekday.$i"       => 'required|max:255'
        //       ]);
        //
        //       $lunch = new Lunch;
        //
        //       $lunch->restaurant_id = $restaurant->id;
        //       $lunch->title = $request->title[$i];
        //       $lunch->price = $request->price[$i];
        //       $lunch->weekday = $request->weekday[$i];
        //
        //       if (!empty($request->file('image')[$i])) {
        //         $image = $request->file('image')[$i];
        //         $filename = time() . $i . '.' . $image->getClientOriginalExtension();
        //         $location = public_path('images/') . $filename;
        //
        //         Image::make($image)->save($location);
        //
        //         $lunch->image = $filename;
        //       } else {
        //         $lunch->image = 'placeholder.jpg';
        //       }
        //
        //       $lunch->save();
        //     }
        //
        //     break;
        // }
      } else {
        // dd($request->price);
        $this->validate($request, [
          'name'          => 'required|max:255',
          'website'       => 'required|max:255',
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

        // switch ($request->count_deals) {
        //   case 1:
        //     // dd('STOP');
        //     $this->validate($request, [
        //       'title.0'         => 'required|max:255',
        //       'image.0'         => 'sometimes',
        //       'price.0'         => 'required',
        //       'weekday.0'       => 'required|max:255'
        //     ]);
        //
        //     $lunch = new Lunch;
        //
        //     $lunch->restaurant_id = $restaurant->id;
        //     $lunch->title = $request->title[0];
        //     $lunch->price = $request->price[0];
        //     $lunch->weekday = $request->weekday[0];
        //
        //     if ($request->hasFile('image')) {
        //       $image = $request->file('image')[0];
        //       $filename = time() . '.' . $image->getClientOriginalExtension();
        //       $location = public_path('images/') . $filename;
        //
        //       Image::make($image)->save($location);
        //
        //       $lunch->image = $filename;
        //     } else {
        //       $lunch->image = 'placeholder.jpg';
        //     }
        //     // dd($lunch);
        //     $lunch->save();
        //
        //     break;
        //   default:
        //     // dd('STOP');
        //     // dd($request->file('image')[2]->isValid());
        //     for ($i = 0; $i < $request->count_deals; $i++) {
        //       $this->validate($request, [
        //         "title.$i"         => 'required|max:255',
        //         "image.$i"         => 'sometimes',
        //         "price.$i"         => 'required',
        //         "weekday.$i"       => 'required|max:255'
        //       ]);
        //
        //       $lunch = new Lunch;
        //
        //       $lunch->restaurant_id = $restaurant->id;
        //       $lunch->title = $request->title[$i];
        //       $lunch->price = $request->price[$i];
        //       $lunch->weekday = $request->weekday[$i];
        //       // dd(empty($request->file('image')[$i]));
        //       if (!empty($request->file('image')[$i])) {
        //         // dd($request->file('image')[1]);
        //         $image = $request->file('image')[$i];
        //         // dd($image);
        //         $filename = time() . $i . '.' . $image->getClientOriginalExtension();
        //         $location = public_path('images/') . $filename;
        //
        //         Image::make($image)->save($location);
        //
        //         $lunch->image = $filename;
        //         // $lunch->save();
        //       } else {
        //         $lunch->image = 'placeholder.jpg';
        //       }
        //       // dd($request->file('image')[1]);
        //       $lunch->save();
        //       // dd($lunch);
        //     }
        //     // dd($lunch);
        //     break;
        // }
      }

      Session::flash('success', 'You have successfully saved Restaurant!');

      return redirect()->route('dashboard.edit', $restaurant->id);
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
      $restaurant = Restaurant::find($id);
      $lunchesByWeekday = Lunch::where('restaurant_id', $restaurant->id)->get()->groupBy('weekday');

      // dd($lunchesByWeekday->);

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

      Session::flash('success', 'You have successfully updated Restaurant!');

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
      // dd($restaurant->lunches()->count() > 1);
      $restaurant->contacts()->delete();
      if ($restaurant->lunches()->count() > 1) {
        foreach ($lunches as $lunch) {
          // dd($lunch->image);
          if (!empty($lunch->image)) {
            Storage::delete($lunch->image);
          }
        }
      }

      $restaurant->lunches()->delete();
      Storage::delete($restaurant->logo);
      $restaurant->delete();

      Session::flash('success', 'The restaurant was successfully deleted!');

      return redirect()->route('dashboard.index');
    }
}
