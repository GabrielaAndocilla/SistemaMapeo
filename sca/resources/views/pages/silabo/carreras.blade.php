@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Silabos</div>

				<div class="panel-body">
					<table class="table">
					<thead>
						<th>Carreras FICA</th>
						<th colspan="2">Acción</th>
					</thead>
				@foreach($datos['carreras'] as $data)
          			<tr>
						@if($data->codigo == Auth::user()->career || Auth::user()->type == 99)
							<td>{{ $data->nombre }}</td>						
							<td><a href="{{ URL::to('materias/especializacion').'/'.$data->codigo }}">Ver Materias</a></td>
						@endif
					</tr>
				@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
