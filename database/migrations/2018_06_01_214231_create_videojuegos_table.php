<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideojuegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videojuegos', function (Blueprint $table) {
           $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->date('fechaEstrenoInicial');
            $table->boolean('publicar')->default(false);
            $table->softDeletes();
            //Asociarlo con un usuario
            $table->unsignedInteger('user_id');
            //--Asociarlo con un usuario
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videojuegos');
    }
}
