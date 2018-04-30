<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lunch extends Model
{
  public function restaurant() {
    return $this->belongsTo('App\Restaurant');
  }

  public function xpaths() {
    return $this->hasMany('App\Xpath');
  }
}
