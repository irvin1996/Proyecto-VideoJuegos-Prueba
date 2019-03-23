<?php
//Siempre tiene que tener el namespace
namespace App;
use Illuminate\Database\Eloquent\Model;
//Soft deleting
use Illuminate\Database\Eloquent\SoftDeletes;

class Videojuego extends Model{

use softDeletes;
protected $dates = ['deleted_at'];

  //Me ayuda para enviarle al laravel un arreglo con todas las propiedades
  protected $fillable=['nombre','descripcion','fechaEstrenoInicial','user_id','imagen'];

  public function likes() {
      return $this->hasMany('App\Like');
}

public function plataformas() {
return $this->belongsToMany('App\Plataforma','videojuego_plataforma','videojuego_id','plataforma_id')->withTimestamps();
}

public function user(){
return  $this->belongsto('App\User');
}

public function getNombreAttribute($value) {
return strtoupper($value);
}

public function setNombreAttribute($value) {
$this->attributes['nombre'] = mb_strtolower($value);
}

/*
  //Esta funcion es para traer todos los video Juegos
  //Los vamos a traer por medio de la session
public function getVideoJuegos($session){
//Precarga de datos
//plugin de docblocker
if (!$session->has('videojuegos')) {
  //aqui llamamos el metodo de crear crearDatos
  $this->crearDatos($session);
}
//Retornar la sesion o un listado que obtengamos de la session
return $session->get('videojuegos');

}

//Esta funcion es para traer solo un video Juego
public function getVideoJuego($session,$id){

  //Precarga de datos
  if (!$session->has('videojuegos')) {
    //aqui llamamos el metodo de crear crearDatos
    $this->crearDatos($session);
  }
  //Retornar la sesion o un listado que obtengamos de la session
  return $session->get('videojuegos')[$id];

}

//Funcion para crear los datos
public function crearDatos($session){

  $vj = [
            [
                'nombre' => 'Super Mario Odyssey',
                'descripcion' => 'Es un videojuego de plataformas de mundo abierto para Nintendo Switch.',
                'fechaEstrenoInicial'=> '2017-10-21'
            ],
            [
                  'nombre' => 'Crash Bandicoot',
                  'descripcion' => 'Es un videojuego de plataformas creado por Naughty Dog para la videoconsola PlayStation.',
                  'fechaEstrenoInicial'=> '1996-09-09'
            ],
            [
                  'nombre' => 'The Legend of Zelda: Breath of the Wild',
                  'descripcion' => 'Un mundo de aventuras, exploración y descubrimientos',
                  'fechaEstrenoInicial'=> '2017-03-03'
            ]
          ];

          //vamos a guardar vj en la session
          $session->put('videojuegos',$vj);

}

//Metodo para crear
public function addVideojuego($session, $nombre, $descripcion,$fechaEstrenoInicial)
    {
      //Esta validacion se podria quitar
        if (!$session->has('videojuegos')) {
            $this->crearDatos($session);
        }
        $Videojuegos = $session->get('videojuegos');
        array_push($Videojuegos, [
          'nombre' => $nombre,
        'descripcion' => $descripcion,
        'fechaEstrenoInicial' => $fechaEstrenoInicial
      ]);
        $session->put('videojuegos', $Videojuegos);
    }


//Metodo para actualizar
public function editVideojuego($session,$id,$nombre, $descripcion,$fechaEstrenoInicial)
    {
      //Como solo seria editar entonces esta validacion no sirve
        //if (!$session->has('videojuegos')) {
          //  $this->crearDatos($session);
      //  }
        $Videojuegos = $session->get('videojuegos');

        $Videojuegos[$id]=[
          'nombre' => $nombre,
        'descripcion' => $descripcion,
        'fechaEstrenoInicial' => $fechaEstrenoInicial
      ];
        $session->put('videojuegos', $Videojuegos);
    }

*/
}
 ?>
