@extends('app')

@section('content')
<?php
function replaceInverse($texto){
  return str_replace("</br>","\n",$texto);
} ?>
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="row">
    <div class="col-md-12">
        <h1 align='center'>Observaciones del Mapeo de la malla curricular {{$datos['periodo']}}</h1>
          <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
        <div class='col-md-12 sca-exportar'>
            <a href="{{URL::to('reportes/rda-observaciones-mapeo-general/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
              <button type="button" class="btn btn-success">
                  <span class="glyphicon glyphicon-export"></span> Excel
              </button>
            </a>
        </div>
      </div>
    </div>
    <div class="row">
       <div class="col-md-12">
        <table class="table table-bordered">
          <tr>
            <th>Rda</th>
            <th>Observación de RDA</th>
            <th>Responsables de RDA</th>
          </tr>
          <tbody>
            @foreach($datos["observaciones"] as $observacion)
            <tr>
              <td>{{ $observacion->rda }}</td>
              <td>{{ replaceInverse($observacion->observacion) }}</td>
              <td>{{ replaceInverse($observacion->responsables) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>
      <br>
      @if($datos["observacion"] != "")
      <table class="table table-bordered">
        <col width="25%">
        <col with="75%">
        <tr>
          <th>Observación General</th>
          <td>{{$datos["observacion"]}}</td>
        </tr>
        <tr>
          <th>Responsables</th>
          <td>{{$datos["responsables"]}}</td>
        </tr>
      </table>
      @endif
    </div>
     </div>
   </div>
 </div>
@endsection
