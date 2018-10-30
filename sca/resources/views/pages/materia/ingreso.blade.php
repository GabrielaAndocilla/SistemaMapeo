@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Ingreso de Materias por Carrera</div>
        <div class="panel-body">
          @if (isset($datos["duplicated"]))
            @if($datos["duplicated"])
            <div class="alert alert-danger"><b>Ops!</b> Las materia ya existe!</div>
            @endif
          @endif
        <form id="materia-form" action="{{URL::to('/gestionar/ingreso-materias').'/'.$datos['carrera']->codigo.'/insertar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              Carrera
            </label>
            <div class="col-md-9">
            {{$datos["carrera"]->nombre}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Área
            </label>
            <div class="col-md-9">
              <select name="areaformacion" class="form-control">
                @foreach ($datos["areas"] as $area)
                  <option value="{{$area->id}}">{{$area->descripcion}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Organización curricular
            </label>
            <div class="col-md-9">
              <select class="form-control" name="organizacioncurricular">
                <option value="1">Formación Básica</option>
                <option value="2">Formación Profesional</option>
                <option value="3">Titulación</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Tipo de asignatura
            </label>
            <div class="col-md-9">
              <select class="form-control" name="tipoasignatura">
                <option value="1">Optativa</option>
                <option value="2">Obligatoria</option>
                <option value="3">Práctica</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Campo de formación
            </label>
            <div class="col-md-9">
              <select class="form-control" name="campoformacion">
                <option value="1">Fundamentos teóricos</option>
                <option value="2">Praxis profesional</option>
                <option value="3">Epistemología y metodología de la investigación</option>
                <option value="4">Integración de saberes, contextos y cultura</option>
                <option value="5">Comunicación y lenguajes</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Categoría
            </label>
            <div class="col-md-9">
              <select class="form-control" name="categoria">
                <option value="0">Carrera</option>
                <option value="1">Generales</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Nombre de la Materia
            </label>
            <div class="col-md-9">
              <input type="text" name="materia" value="" class="form-control" style="text-transform:uppercase">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Siglas de la Materia
            </label>
            <div class="col-md-9">
              <input type="text" name="siglas" value="" class="form-control" style="text-transform:uppercase">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              # Semestre
            </label>
            <div class="col-md-9">
                <select class="form-control" name="semestre" required>
                  <option value="">0</option>
                  @for ($i=1; $i<11 ; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </select>
            </div>
          </div>
          <!-- Requisitos -->
          <div class="model-display requisito-display">
            <div class="form-group ">
              <label class="col-md-offset-3 col-md-9">No ha escogido requisitos</label>
            </div>
          </div>
          <div class="form-group model-requisito hide">
              <div class="col-md-offset-3 col-md-7">
                <div class="form-inputs-style">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <label></lable>
                </div>
              </div>
              <input type="hidden" name="requisitos[]" value="">
            </div>
            <!-- END Requisito -->
          <div class="form-group">
            <label class="control-label col-md-3">
              Prerequsito
            </label>
            <div class="col-md-7">
                <select class="form-control" name="requisito-model">
                  @foreach ($datos["siglas"] as $siga)
                    <option value="{{$siga->codigo_materia}}">{{$siga->codigo_materia}}</option>
                  @endforeach
                </select>
              </select>
            </div>
          <div class="col-md-2">
              <button type="button" class="btn btn-success" onclick="addRequisito()">Añadir</button>
            </div>
          </div>
        <!-- Corequisito -->
        <div class="model-display correquisito-display">
          <div class="form-group ">
            <label class="col-md-offset-3 col-md-9">No tiene corequisitos</label>
          </div>
        </div>
          <div class="form-group model-corequisito hide">
            <div class="col-md-offset-3 col-md-7">
              <div class="form-inputs-style">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              <label></lable>
              </div>
            </div>
            <input type="hidden" name="correquisitos[]" value="">
          </div>
          <!-- END Correquisito -->
          <div class="form-group">
            <label class="control-label col-md-3">
              Corequisito
            </label>
            <div class="col-md-7">
                <select class="form-control" name="corequisito-model">
                  @foreach ($datos["siglas"] as $siga)
                    <option value="{{$siga->codigo_materia}}">{{$siga->codigo_materia}}</option>
                  @endforeach
                </select>
              </select>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-success" onclick="addCorrequisito()">Añadir</button>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Profesor Encargado
            </label>
            <div class="col-md-9">
              <select class="form-control" name="profesor-encargado">
                @foreach( $datos["profesores"] as $encargadoP)
                    <option value="{{ $encargadoP->id }}">{{ $encargadoP->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Créditos
            </label>
            <div class="col-md-9">
              <input type="text" name="creditos" value="" class="form-control" required>
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
  $FORM = $('#materia-form');
  function addCorrequisito()
  {
    var $clone = $FORM.find('div.model-corequisito').clone(true).removeClass('model-corequisito').removeClass('hide');
    var correquisito = $('select[name=corequisito-model]').val();
    if(correquisito != null){
      $('select[name=corequisito-model] option:selected').remove();
      $clone.find('input').val(correquisito);
      $clone.find('label').text(correquisito);
      $FORM.find('div.correquisito-display').append($clone);
    }
  }
  function addRequisito()
  {
    var $clone = $FORM.find('div.model-requisito').clone(true).removeClass('model-requisito').removeClass('hide');
    var correquisito = $('select[name=requisito-model]').val();
    if(correquisito != null){
      $('select[name=requisito-model] option:selected').remove();
      $clone.find('input').val(correquisito);
      $clone.find('label').text(correquisito);
      $FORM.find('div.requisito-display').append($clone);
    }
  }
  function sortSelect(selElem) {
    var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    for (var i=0;i<tmpAry.length;i++) {
        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
        selElem.options[i] = op;
    }
    return;
  }
  $('.close').click(function(){
    var objDeleted = $(this).closest("div.form-group").find("input").val();
    if($(this).closest("div.model-display").hasClass('requisito-display')){
      $('select[name=requisito-model]').append($("<option></option>")
         .attr("value",objDeleted)
         .text(objDeleted));
        // sortSelect($('select[name=corequisito-model]'));
    }else if($(this).closest("div.model-display").hasClass('correquisito-display')){
      $('select[name=corequisito-model]').append($("<option></option>")
         .attr("value",objDeleted)
         .text(objDeleted));
        // sortSelect($('select[name=corequisito-model]'));
    }
    $(this).closest("div.form-group").remove();
  });
  </script>
@endsection
