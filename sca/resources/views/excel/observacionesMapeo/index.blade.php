<?php
function replaceInverse($texto){
  return str_replace("</br>","\n",$texto);
} ?>


<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
  <style type="text/css">
    th,td{
      width: 50;
    }
    tr > td {
      border: 1px solid #000000;
  }
    .rowhide{
      display:none !important;
    }
  </style>

    <table border='1' class="table table-bordered">
      <tr>
        <td>Rda</td>
        <td>Observación Mapeo</td>
        <td>Responsables de RDA</td>
      </tr>
      <tr>
        @foreach($datos["observaciones"] as $observacion)
        <tr>
          <td>{{ $observacion->rda_carrera }}</td>
          <td>{{ replaceInverse($observacion->observaciones) }}</td>
          <td>{{ replaceInverse($observacion->responsables) }}</td>
        </tr>
        @endforeach
      </tr>
    </table>
    <br>
    <br>
    @if($datos["observacion"] != "")
    <table border="1"  class="table table-bordered">
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
    <table border="1"  class="table table-bordered">
      <tr></tr>
      <tr>
        <td>Elaborado por</td>
        <td>Aprobado por</td>
      </tr>
      <tr></tr>
      <tr></tr>
      <tr>
        <td>Revisado por</td>
        <td></td>
      </tr>
    </table>
  </body>
</html>
