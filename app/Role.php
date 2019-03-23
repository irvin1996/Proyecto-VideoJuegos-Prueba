<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['name','permissions'];
    //Relacion con user
    public function users(){
      return $this-belongsToMany('App\User','role_user','role_id','user_id')->withTimestamps();
    }

    public function tieneAcceso(array $permisos)
    {
      foreach ($permisos as $permiso) {
        if ($this->tienePermiso($permiso)) {
        return true;
        }
      }
      return false;
    }

    protected function tienePermiso(string $permiso)
    {
      $listaPermisos=json_decode($this->permissions,true);
      return $listaPermisos[$permiso]??false;
    }
}
