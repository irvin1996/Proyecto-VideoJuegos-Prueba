<!-- Comentario HTML -->
{{-- Comentario de Blade--}}
@extends('layouts.master')
@section('titulo','Lista de VideoJuegos')
@section('contenido')
<div class="row">
  <!--La variable videojuegos es la que se llama en el controller, es la que se agrega en la lista del controller
  //y el vj es para recorrer la lista
  // la variable var_dump es para recorrer todo el detalle de lo que esta recorriendo
  //Se usa mas que todo para depurar-->
  @foreach ($videojuegos as $vj)


<div class="col">
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">{{$vj->nombre}}</h5>
    </div>
    <img src="{{asset('storage/'.$vj->imagen)}}" class="img-thumbnail img-fluid" alt="{{$vj->nombre}}" />
    <div class="card-body">
      <p class="card-text">
      {{$vj->descripcion}}.</p>
      <p class="card-text">
@foreach($vj->plataformas as $plataforma)
<span class="badge badge-pill badge-info">
{{ $plataforma->nombre }}</span>
@endforeach
</p>
      <a href="{{route('vj.videojuego',['id'=>$vj->id])}}" class="btn btn-primary">Ver</a>
    </div>
  </div>
</div>
  @endforeach
</div>
<div class="row">
  <div class="col-md-12 text-center">
    {{$videojuegos->links()}}
  </div>
</div>
@endsection
