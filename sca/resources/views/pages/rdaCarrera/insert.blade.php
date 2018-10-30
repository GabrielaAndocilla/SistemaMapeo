@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Ingreso de RDAs de las Carrera</div>
        <div class="panel-body">
          @if (Session::has('warning'))
            <div class="alert alert-warning">{{Session::get('warning', '')}}</div>
          @endif
        <form action="{{URL::to('/gestionar/rda-carreras').'/'.$datos['cod'].'/insertar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              Carrera
            </label>
            <div class="col-md-9">
                @foreach ($datos["carreras"] as $carrera)
                  @if($carrera->codigo == $datos["cod"])
                    {{$carrera->nombre}}
                    <input type="hidden" name="carrera" value="{{$carrera->codigo}}">
                    @endif
                @endforeach
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3">RDAs de la Universidad</label>
              <input type="hidden" name="rdauniversidad" value="1">
          </div>
          <div id="rda-group">
          </div>
        <div class="form-group model-rda hidden">
            <label class="col-md-offset-3 col-md-9">jalsjdfjadsfjlsd</label>
            <input type="hidden" name="rdauniversidad-model" value="-1">
        </div>
          <div class="form-group">
            <div class="col-md-offset-3 col-md-6">
              <select name="escoger" id="escoger-rda" class="form-control" required>
                @foreach($datos["rdasUniversidad"] as $rda)
                <option value="{{$rda->id}}">{{$rda->rda_universidad}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" id="add" name="add">Añadir</button>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              RDAs de las Carrera
            </label>
            <div class="col-md-9">
              <input type="text" name="rda_carrera" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <input type="submit" name="Guardar" value="Ingresar" class="btn btn-primary" >
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script>
  var $CONTAINER = $('#rda-group');
  var $ESCOGER = $('#escoger-rda');

  $('#add').click(function () {
    var $clone = $('.model-rda').clone(true).removeClass('hidden model-rda');
    $clone.find('input').attr('name' , 'rdauniversidad[]');
    $clone.find('input').val($ESCOGER.val());
    $clone.find('label').text($('#escoger-rda option:selected').text());
    var x = document.getElementById("escoger-rda");
    x.remove(x.selectedIndex);
    $CONTAINER.append($clone);
  });

  </script>
@endsection
