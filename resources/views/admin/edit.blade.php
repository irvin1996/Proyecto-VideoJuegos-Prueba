@extends('layouts.master')

@section('contenido')

  @include('partials.errors')

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.update',['vj'=>$vj->id])}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input
                    type="text"
                    class="form-control"
                    id="nombre"
                    name="nombre"
                    value="{{$vj->nombre}}"
                    >

                </div>
                <div class="form-group">
                    <label for="content">Descripción</label>
                    <textarea
                    class="form-control"
                    id="descripcion"
                    name="descripcion">
                    {{$vj->descripcion}}
                    </textarea>

                </div>
                <div class="form-group">
                    <label for="content">Fecha de Estreno Inicial</label>
                    <input
                    type="date"
                    class="form-control"
                    id="fechaEstrenoInicial"
                    name="fechaEstrenoInicial"
                    value="{{$vj->fechaEstrenoInicial}}"
                    >
                </div>
  <div class="form-group">
                @foreach($plataformas as $plataforma)
                    <div class="form-check">
                           <input
                           class="form-check-input" type="checkbox"
                           name="plataformas[]"
                           value="{{ $plataforma->id }}"
                           {{ $vj->plataformas->contains($plataforma->id) ? 'checked' : '' }}
                           />
                         <label class="form-check-label">{{ $plataforma->nombre }}</label>
                   </div>
               @endforeach
               </div>
                <input type="hidden" name="id" value="{{$vj->id}}"/>
                <div class="form-group">
                  <label>Imagen</label>
                  <input type="file" name="archivoImagen" class="form-control-file" accept="image/*" />
                </div>
                @csrf
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@endsection
