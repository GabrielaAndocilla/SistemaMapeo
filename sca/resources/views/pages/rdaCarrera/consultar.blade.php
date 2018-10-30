@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Ingreso de RDAs de las Carrera</div>
        <div class="panel-body">
          <form action="{{URL::to('/gestionar/rda-carreras/listar')}}" method="GET" class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3">
                  Carrera
                </label>
                <div class="col-md-9">
                  <select class="form-control" name="carrera">
                    @foreach ($carreras as $carrera)
                      @if($carrera->codigo == Auth::user()->career || Auth::user()->type == 99)
                        <option value="{{$carrera->codigo}}">{{$carrera->nombre}}</option>
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
