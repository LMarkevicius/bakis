<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Restaurant;
use App\Contact;
use App\Lunch;
use App\Xpath;
use Image;
use Storage;

class LunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (date('l') == 'Saturday' || date('l') == 'Sunday') {
        $todayslunches = Lunch::where('weekday', 'Monday')->orderBy('created_at', 'DESC')->paginate(6);
      } else {
        $todayslunches = Lunch::where('weekday', date('l'))->orderBy('created_at', 'DESC')->paginate(6);
      }

      $recentlunches = Lunch::orderBy('created_at', 'DESC')->paginate(6);

      return view('lunches.index')->withRecentlunches($recentlunches)->withTodayslunches($todayslunches);
    }

    public function todaysdeals()
    {
      $lunches = new Lunch;
      $queries = [];

      $columns = [
        'restaurant_id', 'price'
      ];

      if (date('l') == 'Saturday' || date('l') == 'Sunday') {
        $lunches = $lunches->where('weekday', 'Monday');
      } else {
        $lunches = $lunches->where('weekday', date('l'));
      }

      foreach ($columns as $column) {
        if (request()->has($column)) {
          if ($column == 'price') {
            $prices = explode('-', request('price'));
            $lunches = $lunches->whereBetween($column, [$prices[0], $prices[1]]);
          } else {
            $lunches = $lunches->where($column, request($column));
          }
          $queries[$column] = request($column);
        }
      }

      $lunches = $lunches->orderBy('created_at', 'DESC')->paginate(9)->appends($queries);

      $restaurants = Restaurant::all();

      return view('lunches.todaysdeals')->withLunches($lunches)->withRestaurants($restaurants);
    }

    public function alldeals()
    {
      $lunches = new Lunch;
      $queries = [];

      $columns = [
        'restaurant_id', 'weekday', 'price'
      ];

      foreach ($columns as $column) {
        if (request()->has($column)) {
          if ($column == 'price') {
            $prices = explode('-', request('price'));
            $lunches = $lunches->whereBetween($column, [$prices[0], $prices[1]]);
          } else {
            $lunches = $lunches->where($column, request($column));
          }
          $queries[$column] = request($column);
        }
      }

      $lunches = $lunches->orderBy('created_at', 'DESC')->paginate(9)->appends($queries);

      $restaurants = Restaurant::all();

      return view('lunches.alldeals')->withLunches($lunches)->withRestaurants($restaurants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($restaurant_id)
    {
      return view('dashboard.lunches.create')->withRestaurantId($restaurant_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $restaurant_id)
    {
      // dd($request->count_deals);


      switch ($request->count_deals) {
        case 1:

          $this->validate($request, [
            'title.0'         => 'required|max:255',
            'image.0'         => 'sometimes',
            'price.0'         => 'required',
            'weekday.0'       => 'required|max:255'
          ]);

          $lunch = new Lunch;

          $lunch->restaurant_id = $restaurant_id;
          $lunch->title = $request->title[0];
          // if ($request->dataurl) {
          //   $lunch->price = $request->price[0];
          // } else {
          $lunch->price = $request->price[0];
          // }
          $lunch->price = $request->price[0];
          $lunch->weekday = $request->weekday[0];
          // dd($request->file('image'));
          // dd($request->hasFile('image'));
          if ($request->hasFile('image')) {

            $image = $request->file('image')[0];
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;

            Image::make($image)->save($location);

            $lunch->image = $filename;
          } elseif (!empty($request->photo_url[0])) {
            // dd($request->photo_url[0]);
            // dd(str_replace('.', '', strstr(basename($request->photo_url[0]), '.')));
            $extension = str_replace('.', '', strstr(basename($request->photo_url[0]), '.'));
            $filename = time() . '.' . $extension;
            $location = public_path('images/') . $filename;

            $exploded = explode('/', $request->photo_url[0]);
            $last = rawurlencode($exploded[count($exploded) - 1]);

            array_pop($exploded);
            array_push($exploded, $last);

            $imploded = implode('/', $exploded);
            // dd($imploded);

            Image::make($imploded)->save($location);

            $lunch->image = $filename;
          } else {
            // dd('lol');
            $lunch->image = 'placeholder.jpg';
          }

          $lunch->save();

          if ($request->title_xpath[0] || $request->image_xpath[0] || $request->price_xpath[0]) {
            $this->validate($request, [
              'dataurl'               => 'required',
              'title_xpath.0'         => 'required',
              'image_xpath.0'         => 'sometimes',
              'price_xpath.0'         => 'required'
            ]);

            $xpath = new Xpath;

            $xpath->lunch_id = $lunch->id;
            $xpath->restaurant_url = $request->dataurl;
            $xpath->title_path = $request->title_xpath[0];
            $xpath->image_path = $request->image_xpath[0];
            $xpath->price_path = $request->price_xpath[0];

            $xpath->save();
          }

          break;
        case 0:
          // Session::flash('errors', 'You have no deals');
          // return redirect()->route('dashboard.edit', $restaurant_id);
          break;
        default:
          for ($i = 0; $i < $request->count_deals; $i++) {
            // if ($request->title_xpath[0] || $request->image_xpath[0] || $request->price_xpath[0]) {
              // $this->validate($request, [
              //
              // ]);

            $this->validate($request, [
              "title.$i"          => 'required|max:255|unique:lunches,title',
              "image.$i"          => 'sometimes',
              "price.$i"          => 'required',
              "weekday.0"         => 'required|max:255'
            ]);

            // $fixed_title = str_replace('""', "''", $request->title[$i]);
            // dd($fixed_title);

            $lunch = new Lunch;

            $lunch->restaurant_id = $restaurant_id;
            $lunch->title = $request->title[$i];

            $lunch->price = $request->price[$i];
            $lunch->weekday = $request->weekday[0];
            // dd($request->photo_url);

            if (!empty($request->file('image')[$i])) {
              $image = $request->file('image')[$i];
              $filename = time() . $i . '.' . $image->getClientOriginalExtension();
              $location = public_path('images/') . $filename;

              Image::make($image)->save($location);

              $lunch->image = $filename;
            } elseif (!empty($request->photo_url[$i])) {
              // dd($request->photo_url);
              // dd(str_replace('.', '', strstr(basename($request->photo_url[0]), '.')));
              $extension = str_replace('.', '', strstr(basename($request->photo_url[$i]), '.'));
              // dd($extension);
              $filename = time() . $i . '.' . $extension;
              // dd($filename);
              $location = public_path('images/') . $filename;
              // dd($location);
              // $corrected_photo = preg_replace('/\s+/', '%20', $request->photo_url[3]);
              $exploded = explode('/', $request->photo_url[$i]);
              $last = rawurlencode($exploded[count($exploded) - 1]);

              array_pop($exploded);
              array_push($exploded, $last);

              // dd($exploded);
              $imploded = implode('/', $exploded);
              // dd($last);
              // dd($imploded);

              Image::make($imploded)->save($location);

              $lunch->image = $filename;
            } else {
              $lunch->image = 'placeholder.jpg';
            }

            $lunch->save();

            if ($request->dataurl != "NODATA") {
              $this->validate($request, [
                "dataurl"           => 'required',
                "title_xpath.$i"    => 'required',
                "image_xpath.$i"    => 'sometimes',
                "price_xpath.$i"    => 'required'
              ]);

              $xpath = new Xpath;

              $xpath->lunch_id = $lunch->id;
              $xpath->restaurant_url = $request->dataurl;
              $xpath->title_path = $request->title_xpath[$i];
              $xpath->image_path = $request->image_xpath[$i];
              $xpath->price_path = $request->price_xpath[$i];

              $xpath->save();
            }


          }

          break;
      }

      Session::flash('success', 'You have successfully added lunch deals!');

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
      // $restaurant = Restaurant::find($id);
      //
      // return view('lunches.show')->withRestaurant($restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($restaurant_id, $id)
    {
      $lunch = Lunch::find($id);

      return view('dashboard.lunches.edit')->withLunch($lunch);
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
        'title'    => 'required|max:255',
        'image'    => 'sometimes',
        'price'    => 'required',
        'weekday'  => 'required|max:255'
      ]);

      $lunch = Lunch::find($id);

      $lunch->title = $request->title;
      $lunch->price = $request->price;
      $lunch->weekday = $request->weekday;

      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $location = public_path('images/') . $filename;

        Image::make($image)->save($location);

        $oldFilename = $lunch->image;

        $lunch->image = $filename;

        Storage::delete($oldFilename);
      }

      $lunch->save();

      Session::flash('success', 'You have successfully updated Lunch Deal!');

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
      $lunch = Lunch::find($id);
      $xpath = Xpath::where('lunch_id', $id)->firstOrFail();

      if (!empty($lunch->image)) {
        Storage::delete($lunch->image);
      }

      $xpath->delete();
      $lunch->delete();

      Session::flash('success', 'The lunch deal was successfully deleted!');

      return redirect()->route('dashboard.edit', $restaurant_id);
    }
}
