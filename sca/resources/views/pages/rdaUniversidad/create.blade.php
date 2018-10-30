@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">Ingreso de RDAs de la Universidad</div>
        <div class="panel-body">

        <form action="{{URL::to('/gestionar/rda-universidad/insertar')}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              RDAs de la Universidad
            </label>
            <div class="col-md-9">
              <input type="text" name="rda" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              RDA de la Universidad Abreviado
            </label>
            <div class="col-md-9">
              <input type="text" name="rdaAbreviado" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Logro Relacionado
            </label>
            <div class="col-md-9">
              <input type="text" name="logrouniversidad" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <input type="submit" name="Guardar" value="Ingresar" class="btn btn-primary" >
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
