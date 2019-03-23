<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideojuegoPlataformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videojuego_plataforma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('videojuego_id')->unsigned();
            $table->integer('plataforma_id')->unsigned();
            $table->timestamps();
            $table->foreign('videojuego_id')->
            references('id')->
            on('videojuegos')->onDelete('cascade');
            $table->foreign('plataforma_id')->
            references('id')->
            on('plataformas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('videojuego_plataforma', function (Blueprint $table) {
          $table->dropForeign('videojuego_plataforma_videojuego_id_foreign');
          $table->dropColumn('videojuego_id');
          $table->dropForeign('videojuego_plataforma_plataforma_id_foreign');
          $table->dropColumn('plataforma_id');
      });
        Schema::dropIfExists('videojuego_plataforma');
    }
}
