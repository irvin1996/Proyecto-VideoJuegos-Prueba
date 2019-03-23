@extends('layouts.master')

@section('contenido')

@if(Session::has('info'))
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-info">{{Session::get('info')}}</p>
            </div>
        </div>
@endif
@can ('create-vj')
  <div class="row">
          <div class="col-md-12">
              <a href="{{ route('admin.create')}}" class="btn btn-success">Nuevo</a>
          </div>
      </div>
@endcan


<table class="table table-hover">
  <thead>
    <tr class="table-success">
      <th scope="col">Nombre</th>
      <th scope="col">Editar</th>
      <th scope="col">Publicar</th>
      @can ('publish-vj')
        <th scope="col">Publicar</th>
      @endcan
      <th scope="col">PDF</th>
      <th scope="col">Eliminar</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($videojuegos as $vj)
      <tr>
        <th scope="row">{{$vj->nombre}}</th>
        @can ('update-vj', $vj)
          <td><a href="{{route('admin.edit',['vj'=>$vj->id])}}">Editar</a></td>
        @endcan
          <td>
          @if($vj->publicar==1)
            Publicado
          @else
          @can('publish-vj')
          <a href="{{route('publish-vj',['id'=>$vj->id])}}">Publicar</a>
        @endcan
        @endif
      </td>
      <td><a href="{{route('admin.pdf',['id'=>$vj->id])}}">Descargar PDF</a></td>
      <td><a href="{{route('ad.delete',['id'=>$vj->id])}}">Eliminar</a></td>
      </tr>

    @endforeach
  </tbody>
</table>
<div class="row">
  <div class="col-md-12 text-center">
    {{$videojuegos->links()}}
  </div>
</div>
@endsection
