@extends('app')

@section('content')
<?php
  function ifExistPreqrequisito($prerequisito,$array){
    foreach($array as $requisito)
    {
      if($requisito->materia_codigo == $prerequisito)
        return true;
    }
    return false;
  }
  function ifExistCorreqrequisito($correquisito,$array){
    foreach($array as $correquisito2)
    {
      if($correquisito2->materia_codigo == $correquisito)
        return true;
    }
    return false;
  }
 ?>
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Actualizar Datos de Materias por Carrera</div>
        <div class="panel-body">
          @if (isset($datos["duplicated"]))
            @if($datos["duplicated"])
            <div class="alert alert-danger"><b>Ops!</b> Las materia ya existe!</div>
            @endif
          @endif
        <form id="materia-form" action="{{URL::to('/gestionar/ingreso-materias').'/'.$datos['materia']->id.'/editar'}}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="control-label col-md-3">
              Carrera
            </label>
            <div class="col-md-9">
            {{$datos["materia"]->carrera}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Área
            </label>
            <div class="col-md-9">
              <select name="areaformacion" class="form-control">
                @foreach ($datos["areas"] as $area)
                @if($area->id == $datos["materia"]->area_formacion)
                  <option value="{{$area->id}}" selected>{{$area->descripcion}}</option>
                  @else
                  <option value="{{$area->id}}">{{$area->descripcion}}</option>
                  @endif
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
                @if($datos["materia"]->organizacion_curricular == 1)
                  <option value="1" selected>Formación Básica</option>
                @else
                  <option value="1">Formación Básica</option>
                @endif
                @if($datos["materia"]->organizacion_curricular == 2)
                  <option value="2" selected>Formación Profesional</option>
                @else
                  <option value="2">Formación Profesional</option>
                @endif
                @if($datos["materia"]->organizacion_curricular == 3)
                    <option value="3" selected>Titulación</option>
                @else
                  <option value="3">Titulación</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Tipo de asignatura
            </label>
            <div class="col-md-9">
              <select class="form-control" name="tipoasignatura">
                @if($datos["materia"]->tipo_asignatura == 1)
                  <option value="1" selected>Optativa</option>
                @else
                  <option value="1">Optativa</option>
                @endif
                @if($datos["materia"]->tipo_asignatura == 2)
                  <option value="2" selected>Obligatoria</option>
                @else
                  <option value="2">Obligatoria</option>
                @endif
                @if($datos["materia"]->tipo_asignatura == 3)
                    <option value="3" selected>Práctica</option>
                @else
                  <option value="3">Práctica</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Campo de formación
            </label>
            <div class="col-md-9">
              <select class="form-control" name="campoformacion">
               @if($datos["materia"]->campo_formacion == 1)
                  <option value="1" selected>Fundamentos teóricos</option>
                @else
                  <option value="1">Fundamentos teóricos</option>
                @endif
                @if($datos["materia"]->campo_formacion == 2)
                  <option value="2" selected>Praxis profesional</option>
                @else
                  <option value="2">Praxis profesional</option>
                @endif
                @if($datos["materia"]->campo_formacion == 3)
                    <option value="3" selected>Epistemología y metodología de la investigación</option>
                @else
                  <option value="3">Epistemología y metodología de la investigación</option>
                @endif
                @if($datos["materia"]->campo_formacion == 4)
                    <option value="4" selected>Integración de saberes, contextos y cultura</option>
                @else
                  <option value="4">Integración de saberes, contextos y cultura</option>
                @endif
                @if($datos["materia"]->campo_formacion == 5)
                    <option value="5" selected>Comunicación y lenguajes</option>
                @else
                  <option value="5">Comunicación y lenguajes</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Categoría
            </label>
            <div class="col-md-9">
              <select class="form-control" name="categoria">
                @if($datos["materia"]->categoria == 0)
                <option value="0" selected>Carrera</option>
                @else
                <option value="0">Carrera</option>
                @endif
                @if($datos["materia"]->categoria == 1)
                <option value="1" selected>Generales</option>
                @else
                <option value="1">Generales</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Nombre de la Materia
            </label>
            <div class="col-md-9">
              <input type="text" name="materia" value="{{$datos['materia']->nombre}}" class="form-control" style="text-transform:uppercase">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Siglas de la Materia
            </label>
            <div class="col-md-9">
              <input type="text" readonly="readonly" name="siglas" value="{{$datos['materia']->sigla}}" class="form-control" style="text-transform:uppercase">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              # Semestre
            </label>
            <div class="col-md-9">
                <select class="form-control" name="semestre">
                  <option value="">0</option>
                  @for ($i=1; $i<11 ; $i++)
                  @if($datos["materia"]->semestre == $i)
                  <option value="{{$i}}" selected>{{$i}}</option>
                    @else
                    <option value="{{$i}}">{{$i}}</option>
                  @endif
                  @endfor
                </select>
              </select>
            </div>
          </div>
          <!-- Requisitos -->
          <div class="model-display requisito-display">
            <!-- <div class="form-group ">
              <label class="col-md-offset-3 col-md-9">No tiene corequisitos</label>
            </div> -->

          @foreach($datos["prerequisitos"] as $requisito)
          <div class="form-group">
              <div class="col-md-offset-3 col-md-7">
                <div class="form-inputs-style">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <label>{{$requisito->materia_codigo}}</lable>
                </div>
              </div>
              <input type="hidden" name="requisitos[]" value="{{$requisito->materia_codigo}}">
            </div>
          @endforeach
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
              <input type="hidden" name="" value="">
            </div>
            <!-- END Requisito -->
          <div class="form-group">
            <label class="control-label col-md-3">
              Prerequsito
            </label>
            <div class="col-md-7">
                <select class="form-control" name="requisito-model">
                    @foreach ($datos["siglas"] as $siga)
                    @if(!ifExistPreqrequisito($siga->codigo_materia,$datos["prerequisitos"]))
                      <option value="{{$siga->codigo_materia}}">{{$siga->codigo_materia}}</option>
                      @endif
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
          <!-- <div class="form-group ">
            <label class="col-md-offset-3 col-md-9">No tiene corequisitos</label>
          </div> -->
            @foreach($datos["correquisitos"] as $correquisito)
            <div class="form-group">
              <div class="col-md-offset-3 col-md-7">
                <div class="form-inputs-style">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <label>{{$correquisito->materia_codigo}}</lable>
                </div>
              </div>
              <input type="hidden" name="correquisitos[]" value="{{$correquisito->materia_codigo}}">
            </div>
            @endforeach
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
            <input type="hidden" name="" value="">
          </div>
          <!-- END Correquisito -->
          <div class="form-group">
            <label class="control-label col-md-3">
              Corequisito
            </label>
            <div class="col-md-7">
                <select class="form-control" name="corequisito-model">
                  @foreach ($datos["siglas"] as $siga)
                  @if(!ifExistCorreqrequisito($siga->codigo_materia,$datos["correquisitos"]))
                    <option value="{{$siga->codigo_materia}}">{{$siga->codigo_materia}}</option>
                    @endif
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
                    @if($datos["materia"]->responsable == $encargadoP->id)
                      <option value="{{ $encargadoP->id }}" selected>{{ $encargadoP->name }}</option>
                    @else
                      @if($encargadoP->type != 99 || Auth::user()->type == 99)
                        <option value="{{ $encargadoP->id }}">{{ $encargadoP->name }}</option>
                      @endif
                    @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3">
              Créditos
            </label>
            <div class="col-md-9">
              <input type="text" name="creditos" value="{{$datos['materia']->creditos}}" class="form-control">
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
  $FORM = $('#materia-form');
  function addCorrequisito()
  {
    var $clone = $FORM.find('div.model-corequisito').clone(true).removeClass('model-corequisito').removeClass('hide');
    var correquisito = $('select[name=corequisito-model]').val();
    if(correquisito != null){
      $('select[name=corequisito-model] option:selected').remove();
      $clone.find('input').val(correquisito);
      $clone.find('input').attr("name", "correquisitos[]");
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
      $clone.find('input').attr("name", "requisitos[]");
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
