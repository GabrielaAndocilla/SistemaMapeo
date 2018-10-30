@extends('app')
<!-- El @ extends dice que estamos heredando de la vista app.blade.php que se encuentra en la carpeta /resources/views
esta app.blade.php es nuestra vista padre -->

@section('content')
<?php $data = $datos["usuarios"]; ?>
<?php
	function swichTipo($id){
		switch ($id) {
			case '1':
				return "Estudiante";
			case '2':
				return "Profesor";
			case '3':
				return "Coordinador";
			case '99':
				return "Superusuario";
			default:
				# code...
				return "???";
		}
	}
?>
<div class="container">
	<div class="card">
		<div class="table-responsive">
			@foreach($datos["carreras"] as $carrera)
			@if($carrera->codigo == $datos["carrera"])
			<h4>{{ $carrera->nombre }}</h4>
			<table class="table table-bordered">
				<thead>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Tipo</th>
				</thead>
				@foreach($datos["usuarios"] as $usuario)
					@if($usuario->carrera == $carrera->codigo)
					<tr>
						<td>{{ $usuario->nombre }}</td>
						<td>{{ $usuario->correo }}</td>
						<td>{{ swichTipo($usuario->tipo) }}</td>
					</tr>
					@endif
				@endforeach
			</table>
			@endif
			@endforeach
		</div>
	</div>
</div>
@endsection
