@extends('app')

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
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
          <h1 align='center'>Resultados de aprendizaje de las materias alineados a los RdA de  la carrera y RdA institucionales {{$datos['periodo']}}</h1>
            <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
          <div class='col-md-12 sca-exportar'>
              <a href="{{URL::to('reportes/rda-perfil-materias/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
                <button type="button" class="btn btn-success">
                  <span class="glyphicon glyphicon-export"></span> Excel
                </button>
              </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
        @foreach($datos["rdaCarrera"] as $ra)
        <div class="table-responsive">
          <table class="table table-bordered">
            <col width="20%">
            <col width="20%">
            <col width="30%">
            <col width="10%">
            <col width="20%">
            <thead>
              <th>Resultados de Aprendizaje Institucionales</th>
              <th>Resultados de Aprendizaje de Perfil de Carrera / Programa Académico</th>
              <th>Resultados de Aprendizaje de Asignaturas</th>
              <th>Nivel (Inicial, Medio, Final)</th>
              <th>Asignatura</th>
            </thead>
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
                @endif
                @if($i==0)
                <td rowspan="{{count($arreglo)}}">{{$ra->rda_carrera}}</td>
                @endif

                <td>{{$arreglo[$i]->rda}}</td>
                <td style="background:{{chooseColor($arreglo[$i]->nivel)}}" class="center-and-middle">{{swichLevel($arreglo[$i]->nivel)}}</td>
                <td class="center-and-middle">{{$arreglo[$i]->codigo_materia}} - {{$arreglo[$i]->nombre_materia}}</td>
              </tr>
              @endfor
              <?php $arreglo = array(); ?>
            </tbody>
          </table>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
