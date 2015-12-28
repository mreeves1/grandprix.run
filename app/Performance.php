<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{

  public function runner()
  {
    return $this->belongsTo(Runner::class);
  }

  public function race()
  {
    return $this->belongsTo(Race::class);
  }

}
