@extends('app')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <h1 align='center'>Observaciones Sílabos ingresados {{$datos['periodo']}}</h1>
      <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
      <div class='col-md-12 sca-exportar'>
          <a href="{{URL::to('reportes/rda-observaciones/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
            <button type="button" class="btn btn-success">
                <span class="glyphicon glyphicon-export"></span> Excel
            </button>
          </a>
      </div>
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <th>Materia</th>
            <th>Descripción</th>
            <th>Observación General del sílabo</th>
            <th>Responsables del sílabo</th>
            <th>Observaciones RdA</th>
          </thead>
          <tbody>
            @foreach($datos["observaciones"] as $observacion)
            <tr>
              <td>{{ $observacion->materia }}</td>
              <td>{{ $observacion->nombre }}</td>
              <td>{{ $observacion->observacion }}</td>
              <td>{{ $observacion->responsables }}</td>
              <td><a href="{{URL::to('/reportes/rda-observaciones').'/'.$observacion->materia.'/detalles/'.$datos['carrera'].'/'.$datos['periodo']}}"><span>Ver Detalle</span></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
