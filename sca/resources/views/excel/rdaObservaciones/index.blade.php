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

    <table class="table table-bordered">
      <tr>
        <td>Materia</td>
        <td>Descripción</td>
        <td>Observación</td>
        <td>Responsables</td>
      </tr>
      <tbody>
        @foreach($datos["observaciones"] as $observacion)
        <tr>
          <td>{{ $observacion->materia }}</td>
          <td>{{ $observacion->nombre }}</td>
          <td>{{ $observacion->observacion }}</td>
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
      </tr>
      <tr></tr>
      <tr></tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </body>
</html>
