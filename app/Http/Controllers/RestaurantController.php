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

      foreach ($columns as $column) {
        if (request()->has($column)) {
          if ($column == 'from') {
            if (request()->has('to')) {
              $lunches = $lunches->whereBetween('price', [request($column), request('to')]);
            } else {
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
}
