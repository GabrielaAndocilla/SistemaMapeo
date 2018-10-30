@extends('app')

@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('/css/loading-bar.min.css')}}" />
@endsection

@section('content')
<div class="container" ng-controller="MateriaGeneralesController as m">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Sílabos</div>

				<div class="panel-body">

						<div class="row">
							<div class="col-lg-8">
								<div class="form-group has-feedback">
					<label class="control-label sr-only" for="inputGroupSuccess4">Input group with success</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
						<input type="search" ng-model="search" class="form-control" id="inputGroupSuccess4" aria-describedby="inputGroupSuccess4Status">
					</div>
				</div>
							</div><!-- /.col-lg-6 -->
							<div class="col-lg-4">
								<select class="form-control" name="areas" ng-model="m.areaSelected" ng-change="m.filtrarDatos()">
									<option value="<% area.id %>" ng-repeat="area in m.areas"><% area.descripcion%></option>
								</select>
							</div>
						</div>

					<table class="table">
						<thead>
							<th>Siglas</th>
							<th>Nombre</th>
							<th>Area</ht>
							<th>Sílabo</th>
						</thead>

						<tr ng-repeat="m in m.materias | filter:search">
							<td><% m.codigo %></td>
							<td><% m.nombre %></td>
							<td><% m.area %></td>
							<td>
								<a target="_blank" href="{{URL::to('silabospdf').'/'}}<% m.pdf %>">PDF</a>

								<a href="{{URL::to('materia')}}<%'/' + m.codigo + '/' + m.carrera + '/edit' %>">Edit</a>

							</td>
						</tr>

					</table>
				<!--	<input name="id" type="hidden" ng-model="m.idCarrera" value="{{$carrera}}"> -->
				<input type="hidden" ng-model="m.idCarrera" name="idCarrera" ng-init="m.idCarrera={{$carrera}};m.getGeneralesMaterias()" value></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{asset('/bower_components/Chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/bower_components/angular-chart.js/dist/angular-chart.js')}}"></script>
<script src="{{asset('/js/loading-bar.min.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/controllers/controller.js')}}"></script>
<script src="{{asset('/js/services/services.js')}}"></script>
@endsection
