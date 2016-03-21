<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
  public function users()
  {
    return $this->hasMany(Users::class);
  }
}
