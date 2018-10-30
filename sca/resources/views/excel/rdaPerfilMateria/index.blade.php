<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
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
  function chooseColor($num){
    switch ($num) {
      case '1':
      # code...
      return "#FFF59D";
      break;
      case '2':
      # code...
      return "#FFCC80";
      break;
      case '3':
      # code...
      return "#C5E1A5";
      break;

      default:
      # code...
      return "";
      break;
    }
  }
  ?>
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
  @foreach($datos["rdaCarrera"] as $ra)

  <table border="1" class="table table-bordered">
    <tr>
      <th>Resultados de Aprendizaje Institucionales</th>
      <th>Resultados de Aprendizaje de Perfil de Carrera / Programa Académico</th>
      <th>Resultados de Aprendizaje de Asignaturas</th>
      <th>Nivel (Inicial, Medio, Final)</th>
      <th>Asignatura</th>
    </tr>
    <tbody>
      @foreach($datos["materias"] as $materia)
      <?php
      if($materia->id == $ra->id){
        array_push($arreglo, $materia);
      }
      ?>
      @endforeach
      @for( $i=0; $i <count($arreglo); $i++)
      <tr>
        @if($i==0)
        <td rowspan="{{count($arreglo)}}">
          <ul>
            @foreach($datos["rdaUniversidad"] as $ru)
            @if($ru->id == $ra->id)
            <li>{{$ru->rda_universidad}}</li>
            @endif
            @endforeach
          </ul>
        </td>
        @else
        <td></td>
        @endif
        @if($i==0)
        <td rowspan="{{count($arreglo)}}">{{$ra->rda_carrera}}</td>
        @else
        <td></td>
        @endif

        <td>{{$arreglo[$i]->rda}}</td>
        <td style="background:{{chooseColor($arreglo[$i]->nivel)}}" class="center-and-middle">{{swichLevel($arreglo[$i]->nivel)}}</td>
        <td class="center-and-middle">{{$arreglo[$i]->codigo_materia}} - {{$arreglo[$i]->nombre_materia}}</td>
      </tr>
      @endfor
      <?php $arreglo = array(); ?>
    </tbody>
  </table>

  @endforeach
  <table border="1"  class="table table-bordered">
    <tr></tr>
    <tr>
      <td>Elaborado por</td>
      <td>Aprobado por</td>
      <td>Revisado por</td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
</body>
</html>
