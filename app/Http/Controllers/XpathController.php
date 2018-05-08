<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Xpath;
use App\Lunch;
use App\Restaurant;
use Session;
use Image;
use Storage;

class XpathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, $restaurantId)
     {
       $xpath_data = json_decode($request->xpath_data);

       $lunch = Lunch::find($xpath_data->lunch_id);


       $match_count = 0;
       $new_lunchdeal = [];

       $html = file_get_contents("$xpath_data->restaurant_url"); //get the html returned from the following url

       $restaurant_doc = new \DOMDocument();

       libxml_use_internal_errors(TRUE); //disable libxml errors

       if (!empty($html)) { //if any html is actually returned
         $restaurant_doc->loadHTML($html);

       	 libxml_clear_errors(); //remove errors for yucky html

         $restaurant_xpath = new \DOMXPath($restaurant_doc);

         $title_path = $restaurant_xpath->query("$xpath_data->title_path");
         $price_path = $restaurant_xpath->query("$xpath_data->price_path");
         $image_path = $restaurant_xpath->query("$xpath_data->image_path");

         if($title_path->length > 0){
           foreach($title_path as $key => $row){
             $result[$key] = $row->nodeValue;
           }
         }

         if($price_path->length > 0){
           foreach($price_path as $key => $row){
             $price_result[$key] = $row->nodeValue;
           }
         }

         if($image_path->length > 0){
           foreach($image_path as $key => $row){
             $image_result[$key] = $row->getAttribute("src");
             // dd($row->getAttribute("src"));
           }
         }

         if (!empty($result[0]) || !empty($price_result[0])) {

           // $sutvarkytas = preg_replace('/\s+/', '', $result[0]);
           $sutvarkytas_price = trim(preg_replace('/[^a-z0-9.]/', '', $price_result[0]));

           $decode_title = utf8_decode($result[0]);
           $fixed_title = trim($decode_title);
           $fixed_title = str_replace('"', "'", $fixed_title);

           // dd([$fixed_title, $request->lunch_title]);

           if ($fixed_title == $request->lunch_title && $sutvarkytas_price == $request->lunch_price) {
            // Jei sutampa tos pacios dienos patiekalas

            $atsakas = "Sutampa!";

            $xpath = Xpath::find($xpath_data->id);

            $xpath->status = "OK";
            $xpath->check_date = date('Y-m-d');

            $xpath->save();

          } else {
            // Jei nesutampa
            $todaysdate = date('l') == "Saturday" || date('l') == "Sunday" ? "Monday" : date('l');
            if ($lunch->weekday != $todaysdate) {
              // Jei nesutampa ir nesutampa patiekalo diena

              $restaurant = Restaurant::find($restaurantId);

              foreach ($restaurant->lunches as $lun) {
                if ($lun->title == $fixed_title) {
                  $match_count++;
                }
              }

              if ($match_count == 0) {
                // Jei nera niekur tokiu paciu patiekalu, tada grazina, kad prideti

                $atsakas = "Different days";

                $new_lunchdeal['restaurant_id'] = $lunch->restaurant_id;
                $new_lunchdeal['title'] = $fixed_title;
                // $new_lunchdeal['image'] = 'placeholder.jpg';
                $new_lunchdeal['price'] = $sutvarkytas_price;
                $new_lunchdeal['weekday'] = $todaysdate;

                if (!empty($image_result[0])) {
                  $new_lunchdeal['image'] = $image_result[0];
                } else {
                  $new_lunchdeal['image'] = 'placeholder.jpg';
                }

              } else {
                // Jei toks jau kazkur yra, pakeicia statusa

                $atsakas = "Jau toks yra!";

                // $new_lunchdeal['restaurant_id'] = $lunch->restaurant_id;
                // $new_lunchdeal['title'] = $fixed_title;
                // $new_lunchdeal['image'] = 'placeholder.jpg';
                // $new_lunchdeal['price'] = $sutvarkytas_price;
                // $new_lunchdeal['weekday'] = date('l');

                $xpath = Xpath::find($xpath_data->id);

                $xpath->status = "OK";
                $xpath->check_date = date('Y-m-d');

                $xpath->save();
              }

            } else {
              // Jeigu visiskai neatitinka, tai updeitina

              $atsakas = "Error";

              $new_lunchdeal['restaurant_id'] = $lunch->restaurant_id;
              $new_lunchdeal['title'] = $fixed_title;
              $new_lunchdeal['image'] = 'placeholder.jpg';
              $new_lunchdeal['price'] = $sutvarkytas_price;
              $new_lunchdeal['weekday'] = $todaysdate;

              $xpath = Xpath::find($xpath_data->id);

              $xpath->status = "NOT OK";
              $xpath->check_date = date('Y-m-d');

              $xpath->save();
            }
          }
        } else {
          // ATSAKAS JEI NERANDA ISVIS TURINIO
        }
       }

       return response()->json(['atsakas' => $atsakas, 'content' => $fixed_title, 'new_lunchdeal' => $new_lunchdeal]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function xpathstore(Request $request, $restaurantId)
    {
      $this->validate($request, [
        'title'         => 'required|max:255',
        'image'         => 'sometimes',
        'price'         => 'required',
        'weekday'       => 'required|max:255'
      ]);

      $lunch = new Lunch;

      $lunch->restaurant_id = $restaurantId;
      $lunch->title = $request->title;
      $lunch->price = $request->price;
      $lunch->weekday = $request->weekday;

      if (!empty($request->image)) {
        $extension = str_replace('.', '', strstr(basename($request->image), '.'));
        $filename = time() . '.' . $extension;
        $location = public_path('images/') . $filename;

        $exploded = explode('/', $request->image);
        $last = utf8_decode($exploded[count($exploded) - 1]);
        $lastlast = rawurlencode($last);

        array_pop($exploded);
        array_push($exploded, $lastlast);
        // dd($last);

        $imploded = implode('/', $exploded);
        // dd($imploded);

        Image::make($imploded)->save($location);

        $lunch->image = $filename;
      } else {
        $lunch->image = 'placeholder.jpg';
      }

      $lunch->save();

      $old_xpath = Xpath::where('lunch_id', $request->lunch_id)->get();
      // dd($old_xpath[0]['restaurant_url']);
      $xpath = new Xpath;

      $xpath->lunch_id = $lunch->id;
      $xpath->restaurant_url = $old_xpath[0]['restaurant_url'];
      $xpath->title_path = $old_xpath[0]['title_path'];
      $xpath->image_path = $old_xpath[0]['image_path'];
      $xpath->price_path = $old_xpath[0]['price_path'];

      $xpath->save();

      Session::flash('success', 'You have successfully added new lunch deal!');

      return redirect()->route('dashboard.edit', $restaurantId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurantId, $id)
    {
      $this->validate($request, [
        'title'         => 'required|max:255',
        'image'         => 'sometimes',
        'price'         => 'required',
        'weekday'       => 'required|max:255'
      ]);

      $lunch = Lunch::find($id);

      $lunch->title = $request->title;
      $lunch->price = $request->price;
      $lunch->weekday = $request->weekday;

      $lunch->save();

      $xpath = Xpath::find($lunch->xpaths[0]['id']);

      $xpath->status = "OK";
      $xpath->check_date = date('Y-m-d');

      $xpath->save();

      Session::flash('success', 'You have successfully added new lunch deal!');

      return redirect()->route('dashboard.edit', $restaurantId);
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
