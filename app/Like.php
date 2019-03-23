<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  public function videojuego() {

    //return $this->belongsTo('App\Videojuego','videojuego_id');
    return $this->belongsTo('App\Videojuego');
}
}
