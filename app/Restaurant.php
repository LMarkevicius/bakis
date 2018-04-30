<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
  public function contacts() {
    return $this->hasMany('App\Contact');
  }

  public function lunches() {
    return $this->hasMany('App\Lunch');
  }
}
