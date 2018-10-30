@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Período</div>
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL::to('/param/periodo')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-2 control-label">Escoja el periodo actual:</label>
              <div class="col-md-10">
                <select name="periodo" id="periodo" class="form-control">
                  @foreach($data["periodos"] as $periodo)
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
