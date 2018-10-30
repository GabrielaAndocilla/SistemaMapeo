@extends('pdf.pdf')
@section('content')
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
<h1 align='center'>Reporte consolidado de mapeo curricular por niveles de logro</h1>
<h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
@foreach($datos["rdaCarrera"] as $ra)
  <table border="1">
    <col width="25%">
    <col width="25%">
    <col width="25%">
    <col width="25%">
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
          <ul>
          @foreach($datos["rdaUniversidad"] as $ru)
          @if($ru->id == $ra->id)
          <li>{{$ru->rda_universidad}}</li>
          @endif
          @endforeach
          </ul>
        </td>
        @endif
        @if($index==0)
        <td rowspan="{{count($niveles)}}">{{$ra->rda_carrera}}</td>
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
@endsection
