@extends('app')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
        <h1 align='center'>Tabla de resumen de asignaturas que aportan a los resultados de aprendizaje de carrera e institucional {{$datos['periodo']}}</h1>
          <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
        <div class="row">
          <div class='col-md-12 sca-exportar'>
            <a href="{{URL::to('reportes/reportes-carrera/exportar?carrera=').$datos['carrera'].'&periodo='.$datos['periodo']}}">
              <button type="button" class="btn btn-success">
                <span class="glyphicon glyphicon-export"></span> Excel
              </button>
            </a>
          </div>
        </div>

        <table class="table table-bordered">
          <col width="33.33%">
          <col width="33.33%">
          <col width="33.33%">
            <thead>
              <th>Resultados de Aprendizaje Institucionales</th>
              <th>Resultados de Aprendizaje de la Carrera</th>
              <th>Materias que Aportan al Resultados de Aprendizaje de la Carrera</th>
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
                    <ul>
                   
						
					@foreach( \Udla\Model\Signature::whereHas('carrerSignatures.periodoMaterias.rdaPeriodoMateria', function($q) use ($ru,$datos) {
						 $q->whereIn('rda_carrera_id',$ru->rdas_carrera()->where('carrera',$datos['carrera'])->get()->pluck('id'));
					})->get() as $ps)
					<li>{{$ps->nombre_materia}}</li>
					@endforeach
				
                      
                    </ul>
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