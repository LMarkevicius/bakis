<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FetchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $restaurantId)
    {
      $this->validate($request, [
        'dataurl' => 'required|url'
      ]);

      $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
      $context = stream_context_create($opts);

      $html = file_get_contents("$request->dataurl", false, $context);

      return response()->json(['content' => $html]);
    }
}
