<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{

  public function races()
  {
    return $this->hasMany(Race::class);
  }

  public function records()
  {
    return $this->hasMany(Record::class);
  }

}
