@extends('app')

@section('content')
<?php
function ifExistRda($ru,$datos){
  for($i=0;$i<count($datos["rdaUniversidadIngresados"]);$i++)
  {
    if($ru == $datos["rdaUniversidadIngresados"][$i]->idRuc)
      return true;
  }
  return false;
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">Ingreso de Estándares de logro de la Carrera</div>
        <div class="panel-body">

        <form action="{{URL::to('/gestionar/ingreso-logros-carrera').'/'.$datos['carrera'].'/insertar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              RDAs de la Universidad
            </label>
            <div class="col-md-9">
              <select name="rdaUniversidad" class="form-control">
                @if(count($datos["rdaUniversidadIngresados"]) > 0)
                @for($i=0;$i<count($datos['rdaUniversidad']);$i++)
                      @if(!ifExistRda($datos['rdaUniversidad'][$i]->id,$datos))
                        <option value="{{ $datos['rdaUniversidad'][$i]->id}}">{{$datos["rdaUniversidad"][$i]->rda_universidad}}</option>
                      @endif
                @endfor
                @else
                  @foreach($datos["rdaUniversidad"] as $ru)
                  <option value="{{ $ru->id}}">{{$ru->rda_universidad}}</option>

                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Logro Rda Carreras
            </label>
            <div class="col-md-9">
              <input type="text" name="logrordacarreras" value="" class="form-control">
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
