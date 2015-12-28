<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{

  public function club()
  {
    return $this->belongsTo(Club::class);
  }

  public function gender()
  {
    return $this->belongsTo(Gender::class);
  }

  public function performances()
  {
    return $this->hasMany(Performance::class);
  }

  public function races()
  {
    return $this->hasManyThrough(Performance::class, Race::class);
  }

}
