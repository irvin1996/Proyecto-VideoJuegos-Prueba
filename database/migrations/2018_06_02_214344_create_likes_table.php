<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('videojuego_id')->unsigned();
            $table->foreign('videojuego_id')->
            references('id')->
            on('videojuegos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('likes', function (Blueprint $table) {
          $table->dropForeign('likes_videojuego_id_foreign');

          $table->dropColumn('videojuego_id');

      });
        Schema::dropIfExists('likes');
    }
}
