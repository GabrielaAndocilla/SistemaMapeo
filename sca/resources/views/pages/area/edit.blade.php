@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Actualizar áreas de formación</div>
        <div class="panel-body">

        <form action="{{URL::to('/gestionar/areas').'/'.$area->id.'/editar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              Carrera
            </label>
            <div class="col-md-9">
              {{$area->nombreCarrera}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Área de formación
            </label>
            <div class="col-md-9">
              <input type="text" name="area" value="{{$area->descripcion}}" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <input type="submit" name="Guardar" value="Actualizar" class="btn btn-primary" >
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
