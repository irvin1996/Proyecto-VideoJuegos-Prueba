<?php

use Illuminate\Database\Seeder;

class VideojuegoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $vj = new \App\Videojuego([
        'nombre' => 'Super Mario Odyssey',
        'descripcion' => 'Es un videojuego de plataformas de mundo abierto para Nintendo Switch.',
        'fechaEstrenoInicial'=> '2017-10-21'
      ]);
      $vj->save();
      $vj = new \App\Videojuego([
        'nombre' => 'Crash Bandicoot',
        'descripcion' => 'Es un videojuego de plataformas creado por Naughty Dog para la videoconsola PlayStation.',
        'fechaEstrenoInicial'=> '1996-09-09'
      ]);
      $vj->save();
      $vj = new \App\Videojuego([
        'nombre' => 'The Legend of Zelda: Breath of the Wild',
        'descripcion' => 'Un mundo de aventuras, exploración y descubrimientos',
        'fechaEstrenoInicial'=> '2017-03-03'
      ]);
      $vj->save();

    }
}
