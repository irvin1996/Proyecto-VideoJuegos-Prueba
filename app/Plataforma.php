<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{

  protected $fillable=['nombre'];

  public function Videojuegos() {
return $this->belongsToMany('App\Videojuego','videojuego_plataforma','plataforma_id','videojuego_id')->withTimestamps();

}
}
