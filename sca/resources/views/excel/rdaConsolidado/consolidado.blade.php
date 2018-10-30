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

  <?php $arreglo = array();
   function swichLevel($num){
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
      return "Final";
      break;

      default:
      # code...
      return "";
      break;
    }
  }
  ?>

    @foreach($datos["rdaCarrera"] as $ra)
      <table border='1' class="table table-bordered">
        <tr>
          <th>Resultados de Aprendizaje Institucionales</th>
          <th>Resultados de Aprendizaje de Perfil de Carrera / Programa Académico</th>
          <th>Nivel (Inicial, Medio, Final)</th>
          <th>Cantidad</th>
        </tr>
        <?php
        $niveles = array();
         foreach ($datos['niveles'] as  $nivel) {
           if($nivel->id == $ra->id)
           {
             array_push($niveles,$nivel);
           }

        }
         ?>
        <tbody>
          @foreach($niveles as $index=>$nivel)
          <tr>
            @if($index==0)
            <td rowspan="{{count($niveles)}}">
              @foreach($datos["rdaUniversidad"] as $ru)
              @if($ru->id == $ra->id)
              <li>{{$ru->rda_universidad}}</li>
              @endif
              @endforeach
            </td>
            @else
            <td></td>
            @endif
            @if($index==0)
            <td rowspan="{{count($niveles)}}">{{$ra->rda_carrera}}</td>
            @else
            <td></td>
            @endif
            <td>{{swichLevel($nivel->nivel)}}</td>
            <td>{{$nivel->cantidad}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <br>
      <br>
    @endforeach
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