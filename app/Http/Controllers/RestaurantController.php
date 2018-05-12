<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Contact;
use App\Lunch;
use Session;
use Image;
use Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $restaurants = Restaurant::withCount('lunches')->orderBy('lunches_count', 'desc')->get();

      return view('restaurants.index')->withRestaurants($restaurants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // if (!empty($request->address) || !empty($request->city) || !empty($request->phone)) {
      //   $this->validate($request, [
      //     'name'          => 'required|max:255',
      //     'website'       => 'required|max:255',
      //     'logo'          => 'required|image',
      //     'address'       => 'required|max:255',
      //     'city'          => 'required|max:255',
      //     'phone'         => 'required|max:255',
      //   ]);
      //
      //   $restaurant = new Restaurant;
      //
      //   $restaurant->name = $request->name;
      //   $restaurant->website = $request->website;
      //
      //   $logo = $request->file('logo');
      //   $filename = time() . '.' . $logo->getClientOriginalExtension();
      //   $location = public_path('images/') . $filename;
      //
      //   Image::make($logo)->save($location);
      //
      //   $restaurant->logo = $filename;
      //
      //   $restaurant->save();
      //
      //   $contact = new Contact;
      //
      //   $contact->restaurant_id = $restaurant->id;
      //   $contact->address = $request->address;
      //   $contact->city = $request->city;
      //   $contact->phone = $request->phone;
      //
      //   $contact->save();
      //
      //   // switch ($request->count_deals) {
      //   //   case 1:
      //   //     $this->validate($request, [
      //   //       'address'       => 'required|max:255',
      //   //       'city'          => 'required|max:255',
      //   //       'phone'         => 'required|max:255',
      //   //       'title.0'         => 'required|max:255',
      //   //       'image.0'         => 'sometimes',
      //   //       'price.0'         => 'required',
      //   //       'weekday.0'       => 'required|max:255'
      //   //     ]);
      //   //
      //   //     $lunch = new Lunch;
      //   //
      //   //     $lunch->restaurant_id = $restaurant->id;
      //   //     $lunch->title = $request->title[0];
      //   //     $lunch->price = $request->price[0];
      //   //     $lunch->weekday = $request->weekday[0];
      //   //
      //   //     if ($request->hasFile('image')) {
      //   //       $image = $request->file('image')[0];
      //   //       $filename = time() . '.' . $image->getClientOriginalExtension();
      //   //       $location = public_path('images/') . $filename;
      //   //
      //   //       Image::make($image)->save($location);
      //   //
      //   //       $lunch->image = $filename;
      //   //     } else {
      //   //       $lunch->image = 'placeholder.jpg';
      //   //     }
      //   //
      //   //     $lunch->save();
      //   //
      //   //     break;
      //   //   default:
      //   //     // dd('OPA')
      //   //     for ($i = 0; $i < $request->count_deals; $i++) {
      //   //       $this->validate($request, [
      //   //         'address'       => 'required|max:255',
      //   //         'city'          => 'required|max:255',
      //   //         'phone'         => 'required|max:255',
      //   //         "title.$i"         => 'required|max:255',
      //   //         "image.$i"         => 'sometimes',
      //   //         "price.$i"         => 'required',
      //   //         "weekday.$i"       => 'required|max:255'
      //   //       ]);
      //   //
      //   //       $lunch = new Lunch;
      //   //
      //   //       $lunch->restaurant_id = $restaurant->id;
      //   //       $lunch->title = $request->title[$i];
      //   //       $lunch->price = $request->price[$i];
      //   //       $lunch->weekday = $request->weekday[$i];
      //   //
      //   //       if (!empty($request->file('image')[$i])) {
      //   //         $image = $request->file('image')[$i];
      //   //         $filename = time() . $i . '.' . $image->getClientOriginalExtension();
      //   //         $location = public_path('images/') . $filename;
      //   //
      //   //         Image::make($image)->save($location);
      //   //
      //   //         $lunch->image = $filename;
      //   //       } else {
      //   //         $lunch->image = 'placeholder.jpg';
      //   //       }
      //   //
      //   //       $lunch->save();
      //   //     }
      //   //
      //   //     break;
      //   // }
      // } else {
      //   // dd($request->price);
      //   $this->validate($request, [
      //     'name'          => 'required|max:255',
      //     'website'       => 'required|max:255',
      //     'logo'          => 'required|image'
      //   ]);
      //
      //   $restaurant = new Restaurant;
      //
      //   $restaurant->name = $request->name;
      //   $restaurant->website = $request->website;
      //
      //   $logo = $request->file('logo');
      //   $filename = time() . '.' . $logo->getClientOriginalExtension();
      //   $location = public_path('images/') . $filename;
      //
      //   Image::make($logo)->save($location);
      //
      //   $restaurant->logo = $filename;
      //
      //   $restaurant->save();
      //
      //   // switch ($request->count_deals) {
      //   //   case 1:
      //   //     // dd('STOP');
      //   //     $this->validate($request, [
      //   //       'title.0'         => 'required|max:255',
      //   //       'image.0'         => 'sometimes',
      //   //       'price.0'         => 'required',
      //   //       'weekday.0'       => 'required|max:255'
      //   //     ]);
      //   //
      //   //     $lunch = new Lunch;
      //   //
      //   //     $lunch->restaurant_id = $restaurant->id;
      //   //     $lunch->title = $request->title[0];
      //   //     $lunch->price = $request->price[0];
      //   //     $lunch->weekday = $request->weekday[0];
      //   //
      //   //     if ($request->hasFile('image')) {
      //   //       $image = $request->file('image')[0];
      //   //       $filename = time() . '.' . $image->getClientOriginalExtension();
      //   //       $location = public_path('images/') . $filename;
      //   //
      //   //       Image::make($image)->save($location);
      //   //
      //   //       $lunch->image = $filename;
      //   //     } else {
      //   //       $lunch->image = 'placeholder.jpg';
      //   //     }
      //   //     // dd($lunch);
      //   //     $lunch->save();
      //   //
      //   //     break;
      //   //   default:
      //   //     // dd('STOP');
      //   //     // dd($request->file('image')[2]->isValid());
      //   //     for ($i = 0; $i < $request->count_deals; $i++) {
      //   //       $this->validate($request, [
      //   //         "title.$i"         => 'required|max:255',
      //   //         "image.$i"         => 'sometimes',
      //   //         "price.$i"         => 'required',
      //   //         "weekday.$i"       => 'required|max:255'
      //   //       ]);
      //   //
      //   //       $lunch = new Lunch;
      //   //
      //   //       $lunch->restaurant_id = $restaurant->id;
      //   //       $lunch->title = $request->title[$i];
      //   //       $lunch->price = $request->price[$i];
      //   //       $lunch->weekday = $request->weekday[$i];
      //   //       // dd(empty($request->file('image')[$i]));
      //   //       if (!empty($request->file('image')[$i])) {
      //   //         // dd($request->file('image')[1]);
      //   //         $image = $request->file('image')[$i];
      //   //         // dd($image);
      //   //         $filename = time() . $i . '.' . $image->getClientOriginalExtension();
      //   //         $location = public_path('images/') . $filename;
      //   //
      //   //         Image::make($image)->save($location);
      //   //
      //   //         $lunch->image = $filename;
      //   //         // $lunch->save();
      //   //       } else {
      //   //         $lunch->image = 'placeholder.jpg';
      //   //       }
      //   //       // dd($request->file('image')[1]);
      //   //       $lunch->save();
      //   //       // dd($lunch);
      //   //     }
      //   //     // dd($lunch);
      //   //     break;
      //   // }
      // }
      //
      // Session::flash('success', 'You have successfully saved Restaurant!');
      //
      // return redirect()->route('lunch.show', $restaurant->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $lunches = new Lunch;
      $queries = [];

      $columns = [
        'weekday', 'from', 'to'
      ];
      // dd('asd');
      foreach ($columns as $column) {
        if (request()->has($column)) {
          if ($column == 'from') {
            if (request()->has('to')) {
              $lunches = $lunches->whereBetween('price', [request($column), request('to')]);
            } else {
              // dd('op');
              $lunches = $lunches->whereBetween('price', [request($column), '15']);
            }
          } else if ($column == 'to') {
            if (request()->has('from')) {
              $lunches = $lunches->whereBetween('price', [request('from'), request($column)]);
            } else {
              $lunches = $lunches->whereBetween('price', ['0', request($column)]);
            }
          } else {
            $lunches = $lunches->where($column, request($column));
          }
          $queries[$column] = request($column);
        }
      }

      $lunches = $lunches->where('restaurant_id', $id)->orderBy('created_at', 'DESC')->paginate(9)->appends($queries);

      $restaurant = Restaurant::find($id);

      return view('restaurants.show')->withRestaurant($restaurant)->withLunches($lunches);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // $restaurant = Restaurant::find($id);
      // $lunchesByWeekday = Lunch::where('restaurant_id', $restaurant->id)->get()->groupBy('weekday');
      //
      // // dd($lunchesByWeekday->);
      //
      // return view('restaurants.edit')->withRestaurant($restaurant)->withLunchesByWeekday($lunchesByWeekday);
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
      // $this->validate($request, [
      //   'name'    => 'required|max:255',
      //   'website' => 'required|max:255',
      //   'logo'    => 'required|image'
      // ]);
      //
      // $restaurant = Restaurant::find($id);
      //
      // $restaurant->name = $request->name;
      // $restaurant->website = $request->website;
      //
      // $logo = $request->file('logo');
      // $filename = time() . '.' . $logo->getClientOriginalExtension();
      // $location = public_path('images/') . $filename;
      // Image::make($logo)->save($location);
      //
      // $oldFilename = $restaurant->logo;
      //
      // $restaurant->logo = $filename;
      //
      // Storage::delete($oldFilename);
      //
      // $restaurant->save();
      //
      // Session::flash('success', 'You have successfully updated Restaurant!');
      //
      // return redirect()->route('lunch.show', $restaurant->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // $restaurant = Restaurant::find($id);
      // $lunches = Lunch::where('restaurant_id', $id)->get();
      // // dd($restaurant->lunches()->count() > 1);
      // $restaurant->contacts()->delete();
      // if ($restaurant->lunches()->count() > 1) {
      //   foreach ($lunches as $lunch) {
      //     // dd($lunch->image);
      //     if (!empty($lunch->image)) {
      //       Storage::delete($lunch->image);
      //     }
      //   }
      // }
      //
      // $restaurant->lunches()->delete();
      // Storage::delete($restaurant->logo);
      // $restaurant->delete();
      //
      // Session::flash('success', 'The restaurant was successfully deleted!');
      //
      // return redirect()->route('restaurant.index');
    }
}
