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
      $html = file_get_contents("$request->dataurl"); //get the html returned from the following url

      // $output = str_replace(array("\r\n", "\r", "\n"), "", $html);
      //
      // $html = str_replace(array("\r\n", "\r"), "\n", $html);
      // $lines = explode("\n", $html);
      // $new_lines = array();
      //
      // foreach ($lines as $i => $line) {
      //     if(!empty($line))
      //         $new_lines[] = trim($line);
      // }
      // echo implode($new_lines);
      //
      // $nowhite = preg_replace('/\n/', '', $html);
      // $data = trim(preg_replace('/\s+/', '', $nowhite));
      // $lesshtml = preg_match('/<body>(.*?)<\/body>/', $data, $match);

      // dd($output);

      $restaurant_doc = new \DOMDocument();

      libxml_use_internal_errors(TRUE); //disable libxml errors

      if(!empty($html)){ //if any html is actually returned

      	$restaurant_doc->loadHTML($html);
        // dd($restaurant_doc);
        $body = $restaurant_doc->getElementsByTagName('body');

        // dd($body);

      	libxml_clear_errors(); //remove errors for yucky html

      	$restaurant_xpath = new \DOMXPath($restaurant_doc);

        // dd($restaurant_xpath);

      	//get all the h2's with an id
        // $pokemon_row = $restaurant_xpath->query('//html/body/div[4]/div/div[3]/div/div/div/div[2]/div/div/div/div/div[4]/div[2]/h3');
      	// // $pokemon_row = $restaurant_xpath->query('//html/body/div[4]/div/div[3]/div/div/div/div[2]/div/div/div/div/div[1]/div[1]/img');
        //
      	// if($pokemon_row->length > 0){
      	// 	foreach($pokemon_row as $row){
      	// 		$jata = $row->nodeValue;
      	// 	}
        //   dd($jata);
      	// } else {
        //   dd('Ne');
        // }
      }

      // dd($request->amazing);



      // $dataurl = ['message' => $request->dataurl];

      return response()->json(['content' => $html, 'special' => $restaurant_doc]);
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
    public function store(Request $request, $restaurantId)
    {
      $html = file_get_contents("$request->dataurl");
      $restaurant_doc = new \DOMDocument();

      $restaurant_doc->loadHTML($html);
      // dd($restaurant_doc.xml);

      $content_xpath = new \DOMXPath($restaurant_doc);
      // dd($content_xpath);
      // dd($html);
      $result = $content_xpath->query('//html/body//div[4]/div/div[3]/div/div/div/div[2]/div/div/div/div/div[1]/div[2]/h3');
      // dd($result);
      $value = $result[0]->nodeValue;
      // dd($value);
      $xpath = ['message' => $request->xpath];

      return response()->json(['message' => $value]);
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
    public function update(Request $request, $id)
    {
        //
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
