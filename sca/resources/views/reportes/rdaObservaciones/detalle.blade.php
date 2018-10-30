@extends('app')

@section('content')
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
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
        <h2 style="text-align: center;">Observaciones</h2>
        <h3 style="text-align: center;">{{$datos["materia"]->nombre_materia}}</h3>
        <div class='col-md-12 sca-exportar'>
          <a href="{{URL::to('reportes/rda-observaciones').'/'.$datos['id'].'/detalles/'.$datos['carrera'].'/'.$datos['periodo'].'/exportar'}}">
            <button type="button" class="btn btn-success">
                <span class="glyphicon glyphicon-export"></span> Excel
            </button>
          </a>
      </div>
        <table class="table table-bordered">
          <thead>
            <th>Observaciones General del sílabo</th>
          </thead>
          <tbody>
            @foreach($datos["observacionesGenerales"]  as $observacionG)
            <tr>
              <td>{{ $observacionG->observacion }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <th>Responsables</th>
          </thead>
          <tbody>
            <tr>
              <td>{{ $datos['periodoMateria']->responsables }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-12">
        <table class="table table-bordered">
          <col width="25%">
          <col width="25%">
          <col width="5%">
          <col width="35%">
          <col width="10%">
          <thead>
            <th>RDA</th>
            <th>MDE</th>
            <th>Nivel</th>
            <th>Observaciones RdA materia</th>
            <th>Responsables</th>
          </thead>
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
      </div>
    </div>
  </div>
</div>
@endsection
