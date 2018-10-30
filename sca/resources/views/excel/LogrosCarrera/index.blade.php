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

    <table class="table table-bordered" border="1">
        <tr>
          <th>Resultados de Aprendizaje Institucionales</th>
          <th>Resultados de Aprendizaje de la Carrera</th>
          <th>Estándares de Logros de RdA Institucionales</th>
          <th>Estándares de Logros de RdA de la Carrera</th>
        </tr>
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
                @if($ru->id)
                  {{$ru->logros}}
                @endif
              </td>
              <td>
              @foreach($datos["logrosCarrera"] as $rucl)
                @if($rucl->rda_uni_id== $ru->id)
                  {{$rucl->logro_carrera}}
                @endif
              @endforeach
              </td>
            </tr>
          @endforeach
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
