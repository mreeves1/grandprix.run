<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{

  public function distance()
  {
    return $this->belongsTo(Distance::class);
  }

  public function performances()
  {
    return $this->hasMany(Performance::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }

}
