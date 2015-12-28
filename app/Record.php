<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{

  public function gender()
  {
    return $this->belongsTo(Gender::class);
  }

  public function distance()
  {
    return $this->belongsTo(Distance::class);
  }

}