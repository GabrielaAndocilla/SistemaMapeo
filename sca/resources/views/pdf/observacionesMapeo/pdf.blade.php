@extends('pdf.pdf')
@section('content')
<?php
function replaceInverse($texto){
  return str_replace("</br>","\n",$texto);
} ?>
<h1 align='center'>Observaciones del Mapeo de la malla curricular</h1>
<h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
<table border="1">
  <col width="50%">
  <col width="50%">
  <tr>
    <td>Rda</td>
    <td>Observación Mapeo</td>
  </tr>
  <tbody>
    @foreach($datos["observaciones"] as $observacion)
    <tr>
      <td>{{ $observacion->rda }}</td>
      <td>{{ replaceInverse($observacion->observacion) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<br>
<br>
@if($datos["observacion"] != "")
<table border="1">
  <col width="25%">
  <col with="75%">
  <tr>
    <th>Observación General</th>
    <td>{{$datos["observacion"]}}</td>
  </tr>
</table>
@endif

@endsection
