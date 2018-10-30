@extends('app')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
        <h1 align='center'>Matriz en cascada de los Resultados de aprendizaje y Estándares de Logro Institucionales VS Carrera {{$datos['periodo']}}</h1>
        <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>

        <div class='col-md-12 sca-exportar'>
          <a href="{{URL::to('reportes/reportes-general-con-logros/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
            <button type="button" class="btn btn-success">
              <span class="glyphicon glyphicon-export"></span> Excel
            </button>
          </a>
        </div>

        <table class="table table-bordered">
            <col width="25%">
            <col width="25%">
            <col width="25%">
            <col width="25%">
            <thead>
              <th>Resultados de Aprendizaje Institucionales</th>
              <th>Resultados de Aprendizaje de la Carrera</th>
              <th>Estándares de Logros de RdA Institucionales</th>
              <th>Estándares de Logros de RdA de la Carrera</th>
            </thead>
            <tbody>
              @foreach($datos["rdaUniversidad"] as $ru)
				@if($ru->rdas_carrera()->where('carrera',$datos['carrera'])->get()->count() > 0)
                <tr>
                  <td>{{$ru->rda_universidad}}</td>
                  <td>
                    <ul>
                      @foreach($ru->rdas_carrera()->where('carrera',$datos['carrera'])->get() as $ra)
                            <li>{{$ra->rda_carrera}}</li>
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
				@endif
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
