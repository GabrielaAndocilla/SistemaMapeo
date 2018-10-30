@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Añadir Periodo</div>
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL::to('/param/periodo/add')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-2 control-label">Año</label>
              <div class="col-md-10">
                <input type="text" name="year" value="{{date('Y')}}" class="form-control"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Semestre</label>
              <div class="col-md-10">
                <select name="period" class="form-control">
                  <option value="1">1</option>
                  <option value="2">2</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">P. Anterior</label>
              <div class="col-md-10">
                <select name="p_anterior" class="form-control">
                  @foreach( $data["periodos"] as $periodo)
                  @if($periodo->codigo == $data["actual"]["codigo"])
                    <option value="{{$periodo->codigo}}" selected>{{$periodo->codigo}}</option>
                  @else
                    <option value="{{$periodo->codigo}}">{{$periodo->codigo}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-2 col-md-10">
                <input type="submit" class="btn btn-primary" name="guardar" value="Guardar" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
