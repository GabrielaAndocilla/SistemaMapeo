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
?>
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
          <h1 align='center'>Reporte consolidado de mapeo curricular por niveles de logro {{$datos['periodo']}}</h1>
          <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
          <div class="row">
          <div class='col-md-12 sca-exportar'>
          <a href="{{URL::to('reportes/rda-perfil-materias-consolidado/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
            <button type="button" class="btn btn-success">
                  <span class="glyphicon glyphicon-export"></span> Excel
            </button>
          </a>
        </div>
      </div>
        @foreach($datos["rdaCarrera"] as $ra)
        <div class="table-responsive">
          <table class="table table-bordered">
            <col width="45%">
            <col width="25%">
            <col width="15%">
            <col width="15%">
            <thead>
              <th>Resultados de Aprendizaje Institucionales</th>
              <th>Resultados de Aprendizaje de Perfil de Carrera / Programa Académico</th>
              <th>Nivel (Inicial, Medio, Final)</th>
              <th>Cantidad</th>
            </thead>
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
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
