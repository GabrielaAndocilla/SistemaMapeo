@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Escoger Carrera</div>
        <div class="panel-body">
          <form action="{{URL::to('/reportes/rda-observaciones/ver')}}" method="GET" class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3">
                  Carrera
                </label>
                <div class="col-md-9">
                  <select class="form-control" name="carrera">
                    @foreach ($datos["carreras"] as $carrera)
                      @if($carrera->codigo == Auth::user()->career || Auth::user()->type == 99)
                        <option value="{{$carrera->codigo}}">{{$carrera->nombre}}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">
                  Período
                </label>
                <div class="col-md-9">
                  <select class="form-control" name="periodo">
                    @foreach ($datos["periodos"] as $periodo)
                      @if(ActualPeriodo::getActualPeriodo()->codigo == $periodo->codigo)
                        <option value="{{$periodo->codigo}}" selected>{{$periodo->codigo}}</option>
                      @else
                        <option value="{{$periodo->codigo}}">{{$periodo->codigo}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit"  class="btn btn-primary">Consultar</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
