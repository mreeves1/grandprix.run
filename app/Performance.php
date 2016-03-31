<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{

  public function users()
  {
    return $this->belongsTo(User::class);
  }

  public function race()
  {
    return $this->belongsTo(Race::class);
  }

  public function distance()
  {
    return $this->belongsTo(Distance::class);
  }

}
