<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//El @ seria para separar la accion
Route::get('/', 'VideojuegosController@getIndex')->name('vj.index');/*<- esto es como un link*/

Route::get('acerca-de',function(){
return view('otros.acerca');
})->name('otros.acerca');/*<- esto es como un link*/

Route::get('videojuego/{id}',['uses'=>'VideojuegosController@getVideoJuego'])->name('vj.videojuego');/*<- esto es como un link*/
Route::get('delete/{id}',['uses'=>'VideojuegosController@getSoftdeleteID','as'=>'ad.delete']);
Route::get('videojuego/{id}/like',['uses'=>'VideojuegosController@getLikeVideoJuego'])->name('vj.videojuego.like');
/*para los de la carpeta admin*/
/*para crear los grupos*/
//Parte del admin
Route::group(['prefix'=>'admin','middleware'=>'auth'],function(){
//uses es para indicarle cual indicador usar
// el as es una forma de hacerlo
Route::get('',['uses'=>'VideojuegosController@getAdminIndex', 'as'=>'admin.index']);/*<- esto es como un link*/

Route::get('create',['uses'=>'VideojuegosController@getAdminCreate','as'=>'admin.create','middleware'=>'can:create-vj']);/*<- esto es como un link*/
Route::post('create',['uses'=>'VideojuegosController@vjAdminCreate'])->name('admin.create');

Route::get('edit/{vj}',['uses'=>'VideojuegosController@getAdminEdit','as'=>'admin.edit','middleware'=>'can:update-vj,vj']);/*<- esto es como un link*/
Route::post('edit{vj}',['uses'=>'VideojuegosController@vjAdminEditar','as'=>'admin.update','can:update-vj,vj']);
});

Route::get('publicar/{vj}',['uses'=>'VideojuegosController@publicar','as'=>'publish-vj','middleware'=>'can:publish-vj']);

Route::group(['prefix'=>'plataforma','middleware'=>'auth'], function() {

Route::get('',['uses' => 'PlataformaController@index','as' => 'plataforma.index']);
Route::post('update',['uses' => 'PlataformaController@update','as' => 'update.plataforma']);
Route::post('store',['uses' => 'PlataformaController@store','as' => 'store.plataforma']);

});
Route::get('crear-grafico/{info?}/{tipo?}',['uses'=>'VideojuegosController@grafico','as'=>'admin.grafico']);

Route::get('decargaPDF/{id}',['uses'=>'VideojuegosController@descargarPDF','as'=>'admin.pdf']);




//Conoce las rutas por defecto
Auth::routes();
