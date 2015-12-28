<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
  public function runners()
  {
    return $this->hasMany(Runner::class);
  }
}
