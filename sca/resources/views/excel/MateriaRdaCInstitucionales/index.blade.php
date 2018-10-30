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
          <th>Resultados de Aprendizaje Institucionales</th>
          <th>Resultados de Aprendizaje de la Carrera</th>
          <th>Materias que Aportan al Resultados de Aprendizaje de la Carrera</th>
        </tr>
        <tr>
          @foreach($datos["rdaUniversidad"] as $ru)
            <tr>
              <td>{{$ru->rda_universidad}}</td>
              <td>
                <ul>
                  @foreach($datos["rdaCarrera"] as $ra)
                  @foreach($datos["rdaUniCarrera"] as $ruc)
                @if($ra->id == $ruc->rda_carrera_id && $ru->id == $ruc->rda_universidad_id)
                  <li>{{$ra->rda_carrera}}</li>
                @endif
                @endforeach
                @endforeach
              </ul>
              </td>
              <td>
                <ul>
                @foreach($datos["materias"] as $materia)
                @if($ru->id == $materia->id)
                <li>{{$materia->nombre_materia}}</li>
                @endif
                @endforeach
                </ul>
              </td>
            </tr>
          @endforeach
        </tr>
        <tr></tr>
        <tr>
          <td>Elaborado por</td>
          <td>Aprobado por</td>
          <td>Revisado por</td>
        </tr>
        <tr>
        <td></td>
        <td></td>
        <td></td>
        </tr>
    </table>
  </body>
</html>
