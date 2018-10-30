@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">Actualización de RDAs de las Carrera</div>
        <div class="panel-body">
          @if (Session::has('warning'))
            <div class="alert alert-warning">{{Session::get('warning', '')}}</div>
          @endif
        <form action="{{URL::to('/gestionar/rda-universidad').'/'.$rda->id.'/editar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              RDA de la Universidad
            </label>
            <div class="col-md-9">
              <input type="text" name="rda" value="{{$rda->rda_universidad}}" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              RDA de la Universidad Abreviado
            </label>
            <div class="col-md-9">
              <input type="text" name="rdaAbreviado" value="{{$rda->rda_universidad_abrev}}" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Logro Relacionado
            </label>
            <div class="col-md-9">
              <input type="text" name="logrouniversidad" value="{{$rda->logros}}" class="form-control">
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
