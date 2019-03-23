<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //Nombre de la puerta
        Gate::define('create-vj',function($user){
          //nombre del permiso
          return $user->tieneAcceso(['create-vj']);
        });

        Gate::define('update-vj',function($user,\App\VideoJuego $vj){
          return $user->tieneAcceso(['update-vj'])or $user->id==$vj->user_id;
        });

        Gate::define('see-all-vj',function($user){
          return $user->tieneRol('supervisor') or $user->tieneRol('propietario');
        });

        Gate::define('publish-vj',function($user){
          return $user->tieneAcceso(['publish-vj']);
        });

    }
}
