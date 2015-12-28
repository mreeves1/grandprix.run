<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{

  public function runners()
  {
    return $this->hasMany(Runner::class);
  }

  public function records()
  {
    return $this->hasMany(Record::class);
  }

}
