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
      Storage::append('check_lunches_log.txt', date("Y-m-d H:i:s") . "**");
      $xpaths = Xpath::all();

      foreach ($xpaths as $number => $xpath) {
        $lunch = Lunch::find($xpath->lunch_id);
        $match_count = 0;

        $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);

        $html = file_get_contents("$xpath->restaurant_url", false, $context); //get the html returned from the following url

        $restaurant_doc = new \DOMDocument();

        libxml_use_internal_errors(TRUE); // disable libxml errors

        if (!empty($html)) { // if any html is actually returned
          $restaurant_doc->loadHTML($html);

          libxml_clear_errors(); //remove errors for yucky html

          $restaurant_xpath = new \DOMXPath($restaurant_doc);

          $title_path = $restaurant_xpath->query("$xpath->title_path");
          $price_path = $restaurant_xpath->query("$xpath->price_path");
          $image_path = $restaurant_xpath->query("$xpath->image_path");

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
            }
          }

          if (!empty($result[0]) || !empty($price_result[0])) {
            $sutvarkytas_price = trim(preg_replace('/[^a-z0-9.]/', '', $price_result[0]));

            $decode_title = utf8_decode($result[0]);
            $fixed_title = trim($decode_title);
            $fixed_title = str_replace('"', "'", $fixed_title);

            if ($fixed_title == $lunch->title && $sutvarkytas_price == $lunch->price) {
             // JEIGU DUOMENYS SUTAMPA

             Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Match / " . $lunch->id);

             $xpath->status = "OK";
             $xpath->check_date = date('Y-m-d');

             $xpath->save();

           } else {
             // JEIGU DUOMENYS NESUTAMPA
             setlocale(LC_TIME, "lt_LT.utf8");

             $today = strftime('%A');

             $todaysdate = $today == "Šeštadienis" || $today == "Sekmadienis" ? "Pirmadienis" : $today;
             if ($lunch->weekday != $todaysdate) {
               // JEIGU NESUTAMPA DUOMENYS IR PATIEKALO DIENA

               $restaurant = Restaurant::find($lunch->restaurant->id);

               foreach ($restaurant->lunches as $lun) {
                 if ($lun->title == $fixed_title) {
                   $match_count++;
                 }
               }

               if ($match_count == 0) {
                 Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Days doesn't match / " . $lunch->id);

                 $new_lunch = new Lunch;

                 $new_lunch->restaurant_id = $lunch->restaurant_id;
                 $new_lunch->title = $fixed_title;
                 $new_lunch->price = $sutvarkytas_price;
                 $new_lunch->weekday = $todaysdate;

                 if (!empty($image_result[0])) {
                   $extension = str_replace('.', '', strstr(basename($image_result[0]), '.'));
                   $filename = time() . '.' . $extension;
                   $location = public_path('images/') . $filename;

                   $exploded = explode('/', $image_result[0]);
                   $last = utf8_decode($exploded[count($exploded) - 1]);
                   $lastlast = rawurlencode($last);

                   array_pop($exploded);
                   array_push($exploded, $lastlast);

                   $imploded = implode('/', $exploded);

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

               } else {
                 // JEIGU TOKS PATIEKALAS JAU YRA DUOMENŲ BAZĖJE

                 Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Already exists / " . $lunch->id);

                 $xpath->status = "OK";
                 $xpath->check_date = date('Y-m-d');

                 $xpath->save();
               }

             } else {
               // JEIGU DUOMENYS VISIŠKAI NEATITINKA, TAI JUOS ATNAUJINA

               Storage::append('check_lunches_log.txt', "#" . ($number + 1) . " / Updated / " . $lunch->id);

               $lunch->title = $fixed_title;
               $lunch->price = $sutvarkytas_price;

               $xpath->status = "OK";
               $xpath->check_date = date('Y-m-d');

               $lunch->save();
               $xpath->save();
             }
           }
         } else {
           // ATSAKAS, JEIGU NERANDA TURINIO
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
        sleep($settings->sleep);
      }
    }
}
