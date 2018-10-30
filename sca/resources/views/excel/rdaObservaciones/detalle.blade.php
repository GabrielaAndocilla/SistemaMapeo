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

  <?php function swichLevel($num){
    switch ($num) {
      case '1':
      # code...
      return "Inicial";
      break;
      case '2':
      # code...
      return "Medio";
      break;
      case '3':
      # code...
      return "Alto";
      break;

      default:
      # code...
      return "";
      break;
    }
  }
  ?>

  <table class="table table-bordered">
    <thead>
      <tr>
      <th>Responsables</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $datos['periodoMateria']->responsables }}</td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered">
    <tr>
      <td colspan="5" align="center">{{$datos["materia"]->nombre_materia}}</td>
    </tr>
    <tr>
      <td>RDA</td>
      <td>MDE</td>
      <td>Nivel</td>
      <td>Observación</td>
      <td>Responsables</td>
    </tr>
    <tbody>
      @foreach($datos["observaciones"]  as $observacion)
      <tr>
        <td>{{ $observacion->rda }}</td>
        <td>{!! $observacion->mde !!}</td>
        <td>{{ swichLevel($observacion->nivel) }}</td>
        <td>{{ $observacion->observaciones }}</td>
        <td>{{ $observacion->responsables }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <table border="1"  class="table table-bordered">
      <tr></tr>
      <tr>
        <td>Elaborado por</td>
        <td>Aprobado por</td>
        <td>Revisado por</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </body>
</html>
