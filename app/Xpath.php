<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xpath extends Model
{
  public function lunch() {
    return $this->belongsTo('App\Lunch');
  }
}
