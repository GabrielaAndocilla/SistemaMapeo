@extends('app')

@section('head')
<script src="{{asset('/js/d3.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/sequence.css')}}"/>
@endsection

@section('content')
<div class="container" ng-controller="ReporteRdaController as rrda">
  <div class="card">
    <div class="row">
      <div class="col-md-12">
        <h1 align='center'>Gráfico de porcentaje de materias que aportan al RdA de la carrera {{$datos['periodo']}}</h1>
        <h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3><br>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div id="main">
              <div id="sequence"></div>
              <div id="chart">
                <div id="explanation" style="visibility: hidden;">
                  <span id="percentage"></span><br/>
              <!--  de Rda que apuntan al rda de la carrera -->
                  <span id="textPercentage"></span>
                </div>
              </div>
            </div>
            <div id="sidebar">
              <input type="checkbox" id="togglelegend"> Mostrar Leyenda<br/>
              <div id="legend" style="visibility: hidden;"></div>
            </div>
      </canvas>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('/js/sequence.js')}}"></script>
<script>init('{{$datos["carrera"]}}');</script>
@endsection
