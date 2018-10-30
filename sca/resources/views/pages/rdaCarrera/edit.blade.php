@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Actualizar de RDAs de las Carrera</div>
        <div class="panel-body">

        <form action="{{URL::to('/gestionar/rda-carreras').'/'.$datos['rda']->id.'/editar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              Carrera
            </label>
            <div class="col-md-9">
              {{$datos["rda"]->nombreCarrera}}
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3">RDAs de la Universidad</label>
          </div>
          <div id="rda-group">
            @foreach($datos["rdaUniversidadEscogidas"] as $rdaUniverisad)
            <div class="form-group">
                <label class="col-md-offset-3 col-md-7">{{$rdaUniverisad->nombreRdaUniversidad}}</label>
                <input type="hidden" name="rdauniversidad[]" value="{{$rdaUniverisad->rda_universidad_id}}">
                <button type="button" name="eliminar" class="btn btn-danger btn-delete">Eliminar</button>
            </div>
            @endforeach
        </div>
        <div class="form-group model-rda hidden">
            <label class="col-md-offset-3 col-md-7"> </label>
            <input type="hidden" name="rdauniversidad-model" value="-1">
            <button type="button" name="eliminar" class="btn btn-danger btn-delete" onclick="eliminar()">Eliminar</button>
        </div>
          <div class="form-group">
            <div class="col-md-offset-3 col-md-6">
              <select name="escoger" id="escoger-rda" class="form-control" >
                  @foreach($datos["rdaUniversidadNoEscogidos"] as $rda)
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
              <input type="text" name="rda" value="{{$datos['rda']->rda_carrera}}" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <input type="submit" name="Guardar" value="Actualizar" class="btn btn-primary" >
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
    if($ESCOGER.children('option').length < 1){
      $('#add').prop('disabled', true);
    }
    else{
      $('#add').prop('disabled', false);
    }
  });

  $('.btn-delete').click(function(){
    var $this = $(this);
    var divToDelete = $($this.context.parentElement);
    var x = document.getElementById("escoger-rda");
    var option = $(document.createElement('option'));
    option.val(divToDelete.find('input').val());
    option.text(divToDelete.find('label').text());
     $(x).append(option);
     divToDelete.remove();
     if($ESCOGER.children('option').length < 1){
        $('#add').prop('disabled', true);
      }
      else{
        $('#add').prop('disabled', false);
      }
  });


  </script>
@endsection
