<?php

use Illuminate\Database\Seeder;

class PlataformaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $plataforma= new \App\Plataforma();
      $plataforma->nombre = 'Nintendo Switch';
      $plataforma->save();

      $plataforma= new \App\Plataforma();
      $plataforma->nombre = 'Play Station 4';
      $plataforma->save();

      $plataforma= new \App\Plataforma();
      $plataforma->nombre = 'Wii';
      $plataforma->save();
    }
}
