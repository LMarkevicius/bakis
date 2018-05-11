<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use App\Lunch;
use App\Xpath;
use App\Restaurant;
use App\Settings;
use Image;
use Storage;
// use Log;

class ChechForNewLunches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckForNewLunches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new lunch deals';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // Log::error('This definitely should have run!');
      Storage::append('check_lunches_log.txt', date("Y-m-d H:i:s") . "**");
      $xpaths = Xpath::all();

      foreach ($xpaths as $number => $xpath) {
        // $xpath_data = json_decode($request->xpath_data);

        $lunch = Lunch::find($xpath->lunch_id);
        // dd($lunch->title);

        // dd();

        $match_count = 0;
        // $new_lunchdeal = [];

        $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
        //Basically adding headers to the request
        $context = stream_context_create($opts);

        $html = file_get_contents("$xpath->restaurant_url", false, $context); //get the html returned from the following url

        $restaurant_doc = new \DOMDocument();

        libxml_use_internal_errors(TRUE); //disable libxml errors

        if (!empty($html)) { //if any html is actually returned
          $restaurant_doc->loadHTML($html);

          libxml_clear_errors(); //remove errors for yucky html

          $restaurant_xpath = new \DOMXPath($restaurant_doc);

          $title_path = $restaurant_xpath->query("$xpath->title_path");
          $price_path = $restaurant_xpath->query("$xpath->price_path");
          $image_path = $restaurant_xpath->query("$xpath->image_path");

          // dd($image_path);

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

          // dd($image_result[0]);


          if (!empty($result[0]) || !empty($price_result[0])) {
            // $sutvarkytas = preg_replace('/\s+/', '', $result[0]);
            // dd($result[0]);
            $sutvarkytas_price = trim(preg_replace('/[^a-z0-9.]/', '', $price_result[0]));

            $decode_title = utf8_decode($result[0]);
            $fixed_title = trim($decode_title);
            $fixed_title = str_replace('"', "'", $fixed_title);

            // dd([$fixed_title, $request->lunch_title]);

            // dd($lunch->title);
            if ($fixed_title == $lunch->title && $sutvarkytas_price == $lunch->price) {
             // Jei sutampa tos pacios dienos patiekalas
             // dd("sutampa viskas");
             // $atsakas = "Sutampa!";
             // Log::useDailyFiles(public_path('logs/') . 'check_lunches_log.log');
             // Log::info(['Sutampa']);

             // $xpath = Xpath::find($xpath_data->id);

             Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Match / " . $lunch->id);

             $xpath->status = "OK";
             $xpath->check_date = date('Y-m-d');

             $xpath->save();

           } else {
             // Jei nesutampa
             $todaysdate = date('l') == "Saturday" || date('l') == "Sunday" ? "Monday" : date('l');
             if ($lunch->weekday != $todaysdate) {
               // Jei nesutampa ir nesutampa patiekalo diena
               // dd("nesutampa diena");


               $restaurant = Restaurant::find($lunch->restaurant->id);

               foreach ($restaurant->lunches as $lun) {
                 if ($lun->title == $fixed_title) {
                   $match_count++;
                 }
               }

               if ($match_count == 0) {
                 // Jei nera niekur tokiu paciu patiekalu, tada grazina, kad prideti

                 // $atsakas = "Different days";
                 Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Days doesn't match / " . $lunch->id);

                 $new_lunch = new Lunch;

                 $new_lunch->restaurant_id = $lunch->restaurant_id;
                 $new_lunch->title = $fixed_title;
                 // $new_lunch->image = 'placeholder.jpg';
                 $new_lunch->price = $sutvarkytas_price;
                 $new_lunch->weekday = $todaysdate;

                 if (!empty($image_result[0])) {
                   // dd($image_result[0]);
                   // dd(str_replace('.', '', strstr(basename($request->photo_url[0]), '.')));
//                    $extension = str_replace('.', '', strstr(basename($image_result[0]), '.'));
//                    $filename = time() . '.' . $extension;
//                    $location = public_path('images/') . $filename;
//
//                    $exploded = explode('/', $image_result[0]);
//
//                    $last = utf8_decode($exploded[count($exploded) - 1]);
//                    // $last = rawurlencode($last);
//                    $last = str_replace(" ", "%20", $last);
//                    // dd($last);
// // dd("O");
//                    array_pop($exploded);
//                    array_push($exploded, $last);
//
//                    // dd($exploded);
//                    $imploded = implode('/', $exploded);
//                    dd($imploded);
//
//                    Image::make($imploded)->save($location);
                   // dd("O");

                   $extension = str_replace('.', '', strstr(basename($image_result[0]), '.'));
                   $filename = time() . '.' . $extension;
                   $location = public_path('images/') . $filename;

                   $exploded = explode('/', $image_result[0]);
                   $last = utf8_decode($exploded[count($exploded) - 1]);
                   $lastlast = rawurlencode($last);

                   array_pop($exploded);
                   array_push($exploded, $lastlast);
                   // dd($last);

                   $imploded = implode('/', $exploded);
                   // dd($imploded);

                   Image::make($imploded)->save($location);

                   $new_lunch->image = $filename;
                 } else {
                   $new_lunch = 'placeholder.jpg';
                 }

                 $new_lunch->save();

                 $new_xpath = new Xpath;

                 $new_xpath->lunch_id = $new_lunch->id;
                 $new_xpath->restaurant_url = $xpath->restaurant_url;
                 $new_xpath->title_path = $xpath->title_path;
                 $new_xpath->image_path = $xpath->image_path;
                 $new_xpath->price_path = $xpath->price_path;
                 $new_xpath->status = "OK";
                 $new_xpath->check_date = date('Y-m-d');

                 $new_xpath->save();

                 // $lunch->delete();
                 // $xpath->delete();

               } else {
                 // Jei toks jau kazkur yra, pakeicia statusa

                 // $atsakas = "Jau toks yra!";
                 // dd("toks yra");
                 Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Already exists / " . $lunch->id);

                 // $new_lunchdeal['restaurant_id'] = $lunch->restaurant_id;
                 // $new_lunchdeal['title'] = $fixed_title;
                 // $new_lunchdeal['image'] = 'placeholder.jpg';
                 // $new_lunchdeal['price'] = $sutvarkytas_price;
                 // $new_lunchdeal['weekday'] = date('l');

                 // $xpath = Xpath::find($xpath_data->id);

                 $xpath->status = "OK";
                 $xpath->check_date = date('Y-m-d');

                 $xpath->save();
               }

             } else {
               // Jeigu visiskai neatitinka, tai updeitina

               // $atsakas = "Error";
               // dd("niekas nesutampa");
               Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Updated / " . $lunch->id);

                // $lunch->restaurant= $lunch->restaurant_id;
               $lunch->title = $fixed_title;
               // $new_lunchdeal['image'] = 'placeholder.jpg';
               $lunch->price = $sutvarkytas_price;
               // $new_lunchdeal['weekday'] = $todaysdate;

               // $xpath = Xpath::find($xpath_data->id);

               $xpath->status = "OK";
               $xpath->check_date = date('Y-m-d');

               $lunch->save();
               $xpath->save();
             }
           }
         } else {
           // ATSAKAS JEI NERANDA ISVIS TURINIO
           Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Error / " . $lunch->id);

           $xpath->status = "NOT OK";
           $xpath->check_date = date('Y-m-d');

           $xpath->save();
         }


       } else {
         Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Error / " . $lunch->id);

         $xpath->status = "NOT OK";
         $xpath->check_date = date('Y-m-d');

         $xpath->save();
       }

        $settings = Settings::find(1);
        // Storage::append('check_lunches_log.txt', date('H:m:s'));
        sleep($settings->sleep);
      }
    }
}
