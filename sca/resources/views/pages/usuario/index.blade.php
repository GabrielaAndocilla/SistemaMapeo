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
			<!-- Aqui vamos a mostrar la tabla que deseamos utilizar
			Le decimos que table va a tener la clasee de estilos .table
			para mayor informacion en getbootstrap.com
			es para darle ese estilo, pero si prefieres le damos otro
			-->
			@if(Auth::user()->type == 99)
			<h4>Decano</h4>
			<table class="table table-bordered">
				<thead>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Tipo</th>
				</thead>
				@foreach($datos["usuarios"] as $usuario)
					@if($usuario->carrera == 0)
					<tr>
						<td>{{ $usuario->nombre }}</td>
						<td>{{ $usuario->correo }}</td>
						<td>{{ swichTipo($usuario->tipo) }}</td>
					</tr>
					@endif
				@endforeach
			</table>
			@endif

			@foreach($datos["carreras"] as $carrera)
			@if($carrera->codigo == Auth::user()->career || Auth::user()->type == 99)
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
