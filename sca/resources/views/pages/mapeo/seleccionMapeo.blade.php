@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Selección de Mapeos</div>
        <div class="panel-body">
          <table class="table">
          <thead>
            <th>Mapeo</th>
            <th>Acción</th>
          </thead>
          <tr>
            <td>Materias_Carrera</td>
            <td><a href="{{URL::to('mapeo')}}<%'/' + m.codigo + '/' + m.carrera + '/edit' %>">Ver Mapeo</a></td>
          </tr>
          <tr>
            <td>Carrera_Institucionales</td>
            <td><a href="{{URL::to('mapeocarrera')}}<%'/' + m.codigo + '/' + m.carrera + '/edit' %>">Ver Mapeo</a></td>
          </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<!--@foreach($datos as $data)
          <tr>
            <td>Materias_Carrera</td>
            <td><a href="{{ URL::to('mapeo').'/'.$data->codigo }}">Ver Mapeo</a></td>
          </tr>
          <tr>
            <td>Carrera_Institucionales</td>
            <td><a href="{{ URL::to('mapeocarrera').'/'.$data->codigo }}">Ver Mapeo</a></td>
          </tr>
          @endforeach-->