@extends('app')

@section('head')

<link type="text/css" rel="stylesheet" href="{{URL::to('css/qunit.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('css/tablesaw.css')}}">
<style>
.rowhide{
  display:none !important;
}
</style>
@endsection

@section('content')
<?php $materias = $datos["materias"]; ?>
<?php function swichLevel($num){
  switch ($num) {
    case '1':
    # code...
    return "Inicial";
    break;
    case '2':
    # code...
    return "Medio";
    break;
    case '3':
    # code...
    return "Final";
    break;

    default:
    # code...
    return "";
    break;
  }
}

?>
<div class="container-fluid">
  <div class="card">
      <div id="result" class="alert alert-success hidden">Se ha guardado exitosamente!</div>
      @if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> Ha ocurrido un error<br><br>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
@if (Session::has('mensaje'))
  <div class="alert alert-success">{{Session::get('mensaje', '')}}</div>
@endif
    <div class="row">
        <h1 align='center'>Mapeo Curricular de la Carrera {{$datos['periodo']}}</h1>
      <div class="col-sm-10">
        <button onclick="saveRda({{$datos['carrera']}},'{{$datos['periodo']}}', '{{csrf_token()}}')" type="button" class="btn btn-primary">Actualizar</button>
             <a href="{{URL::to('mapeo').'/'.$datos['carrera'].'/'.$datos['periodo'].'/exportar'}}" <button type="button" class="btn btn-success">Exportar</button></a>
          <label id="export"></label>
      </div>
    </div>
    <div class="row">
      <!-- Begin Table -->
      <div id="table" class="table-editable table-responsive table-mapeo">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <p class="text-right" class="col-md-12">Filtrado por materias</p>
        <table id="mapeo-table-view" class="tablesaw table table-bordered" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="font-size:9px;">
          <thead>
            <tr scope="row" data-tablesaw-sortable-row data-tablesaw-priority="persist">
              <th class="headcol" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">RDA INSTITUCIONALES</th>
              <th class="headcol" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PERFIL DE CARRERA/ASIGNATURAS</th>
              <?php $i_f=0;?>
              @foreach($materias as $materia)
              <th colspan="2" data-tablesaw-sortable-col data-tablesaw-priority="{{ $i_f }}">{{ $materia->nombre_materia}}</th>
              <?php $i_f++;?>
              @endforeach
              <th class="headcol" class="observaciones-title" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Observaciones</th>
              <th class="headcol" class="observaciones-title" scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Responsables</th>
            </tr>
          </thead>
          <tbody>
            <tr data-tablesaw-rotable-row data-tablesaw-priority="1">
              <td rowspan="5"></td>
              <td>Créditos</td>
              @foreach($materias as $materia)
              <td colspan="2">{{ $materia->creditos}}</td>
              <td class="rowhide"></td>
              @endforeach
              <!-- Observaciones -->
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="rowhide"></td>
              <td>Tipo de Asignatura</td>
              @foreach($materias as $materia)
              <td colspan="2">Obligatoria</td>
              <td class="rowhide"></td>
              @endforeach
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="rowhide"></td>
              <td>Área de formación</td>
              @foreach($materias as $materia)
              <td colspan="2">{{$materia->area}}</td>
              <td class="rowhide"></td>
              @endforeach
              <!-- Observaciones -->
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="rowhide"></td>
              <td>Siglas de asignatura: prerequisito/corequisito</td>
              @foreach($materias as $materia)
              <td colspan="2">

                @for($i=0;$i<count($materia->prerequisitos);$i++)
                  {{$materia->prerequisitos[$i]->materia_codigo}} {{','}}
                @endfor

                @if( count($materia->correquisitos) > 0)
                {{'/'}}
                  @foreach($materia->correquisitos as $correquisito)
                  {{$correquisito->materia_codigo}} {{','}}
                  @endforeach
                @endif
              </td>
              <td class="rowhide"></td>
              @endforeach
              <!-- Observaciones -->
              <td></td>
                <td></td>
            </tr>
            <!-- Plantilla -->
            <tr>
              <td class="rowhide"></td>
              <td></td>
              @for($j=0;$j < count($materias) ;$j++)

              <td><b>RDA:</b></td>
              <td><b>MDE:</b></td>

              @endfor
              <!-- Observaciones -->
              <td></td>
                <td></td>
            </tr>

            <!-- End plantilla -->
            @for($i=0;$i < count($datos["rdaCarreras"]);$i++)
            <tr>
              <td>
                <ul>
                @foreach($datos["rdaUniversidad"] as $rus)
                @if($rus->id == $datos["rdaCarreras"][$i]->id)
                <li>{{$rus->rda_universidad_abrev}}</li>
                @endif
                @endforeach
                </ul>
              </td>
              <td class="row-rda" rowspan="2">{{$datos["rdaCarreras"][$i]->nombre}}</td>
              @for($j=0;$j < count($materias) ;$j++)
              @if(count($materias[$j]->rdaCarrera[$i]->rdaMateria) > 0)
              <td>
                @foreach($materias[$j]->rdaCarrera[$i]->rdaMateria as $rdaM)
                {!!$rdaM->rda . "<br/><br/>"!!}
                @endforeach
              </td>
              <td>
                @foreach($materias[$j]->rdaCarrera[$i]->rdaMateria as $rdaM)
                {!!$rdaM->mde . "<br/><br/>"!!}
                @endforeach
              </td>
              @else
              <td></td>
              <td></td>
              @endif
              @endfor
              <!-- Observaciones -->
              @if($i < count($datos["observaciones"]))
                @if($datos["periodo"] == $datos["periodoActual"])
                  <td style="background: #FCFFD2 !important;" contenteditable="true" class="observaciones wrapword">{{$datos["observaciones"][$i]->observaciones}}</td>
                @else
                  <td style="background: #FCFFD2 !important;" contenteditable="false" class="observaciones wrapword">{{$datos["observaciones"][$i]->observaciones}}</td>
                @endif
              @else
                @if($datos["periodo"] == $datos["periodoActual"])
                  <td style="background: #FCFFD2 !important;" contenteditable="true" class="observaciones wrapword"></td>
                @else
                  <td style="background: #FCFFD2 !important;" contenteditable="false" class="observaciones wrapword"></td>
                @endif
              @endif

              <!-- Representantes -->
              @if($i < count($datos["observaciones"]))
                @if($datos["periodo"] == $datos["periodoActual"])
                  <td style="background: #FCFFD2 !important;" contenteditable="true" class="responsables wrapword">{{$datos["observaciones"][$i]->responsables}}</td>
                @else
                  <td style="background: #FCFFD2 !important;" contenteditable="false" class="responsables wrapword">{{$datos["observaciones"][$i]->responsables}}</td>
                @endif
              @else
                @if($datos["periodo"] == $datos["periodoActual"])
                  <td style="background: #FCFFD2 !important;" contenteditable="true" class="responsables wrapword"></td>
                @else
                  <td style="background: #FCFFD2 !important;" contenteditable="false" class="responsables wrapword"></td>
                @endif
              @endif
            </tr>
            <tr>
              <td class="rowhide"></td>
              <td>Nivel de adquisicion Rda:</td>
              @for($j=0;$j < count($materias) ;$j++)
              @if(count($materias[$j]->rdaCarrera[$i]->rdaMateria) > 0)
              <td colspan="2">{{swichLevel($materias[$j]->rdaCarrera[$i]->rdaMateria[0]->nivel)}}</td>
              <td class="rowhide"></td>
              @else
              <td colspan="2"></td>
              <td class="rowhide"></td>
              @endif
              @endfor
              <!-- Observaciones -->
              <td></td>
              <td></td>
            </tr>
            @endfor
          </tbody>
        </table>
        <!-- End Table -->
      </div>
      <form class="form-horizontal" method="POST" action="{{URL::to('/mapeo').'/'.$datos['carrera']}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label class="col-md-2">
            Observaciones:
          </label>
          <div class="col-md-10">
            @if($datos["periodo"] == $datos["periodoActual"])
            <textarea class="form-control" name="observacion" required>{{$datos["observacion"]}}</textarea>
            @else
              <textarea class="form-control" name="observacion" readonly="readonly">{{$datos["observacion"]}}</textarea>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2">
            Responsables:
          </label>
          <div class="col-md-10">
            @if($datos["periodo"] == $datos["periodoActual"])
            <textarea class="form-control" name="responsables" required>{{$datos["responsables"]}}</textarea>
            @else
              <textarea class="form-control" name="responsables" readonly="readonly">{{$datos["responsables"]}}</textarea>
            @endif
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-4">
            @if($datos["periodo"] == $datos["periodoActual"])
            <input type="submit" class="btn btn-primary" name="submit" value="Añadir Observación" >
            @else
              <input type="hidden" class="btn btn-primary" name="submit" value="Añadir Observación" disabled="disabled" >
            @endif
          </div>
        </div>
      </form>

    </div> <!-- End Card -->
  </div>
</div>
@endsection
@section('scripts')
<script src="{{URL::to('/js/qunit.js')}}"></script>

<!--[if lt IE 9]><script src="{{URL::to('/js/respond.js')}}"></script><![endif]-->
<script src="{{URL::to('/js/tablesaw.js')}}"></script>


<script>

var $TABLE = $('#table');
var $EXPORT = $('#export');

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

function saveRda($id,$periodo,$token){
  //var $rows = $TABLE.find('.observaciones');
  console.log($periodo);
  var headers = [];
  var hResponsable = [];
  var data = [];
    var dataR = [];
  var datos = {};
  var $mensaje = $('#result');

  // Get the headers (add special header logic here)
  //$($rows.shift()).find('th:not(:empty)').each(function () {
  $('.observaciones').each(function() {
    headers.push("observaciones");
  });

  $('.responsables').each(function() {
    hResponsable.push("responsables");
  });

  // Turn all existing rows into a loopable array
//  $rows.each(function () {
    var $td = $('.observaciones');
    console.log($td.eq(0).text());
    var h = {};

    var $tdR = $('.responsables');
    console.log($tdR.eq(0).text());
    var h2 = {};
    // Use the headers from earlier to name our hash keys
    headers.forEach(function (header, i) {
      //if($td.eq(i).find('select.form-control').length){
        //h[header] = $td.eq(i).find('select.form-control').val();
      //}else{
        h[i] = replaceSpace($td.eq(i).text());
      //}
    });
    hResponsable.forEach(function (header, i) {
      //if($td.eq(i).find('select.form-control').length){
        //h[header] = $td.eq(i).find('select.form-control').val();
      //}else{
        h2[i] = replaceSpace($tdR.eq(i).text());
      //}
    });
    data.push(h);
    dataR.push(h2);

  //});
  datos = {
    periodo:$periodo,
    carrera: $id,
    datos: data,
    res: dataR
  }

  // Output the result
 //$EXPORT.text(JSON.stringify(datos));
  $.ajaxSetup(
    {
      headers:
      {
        'X-CSRF-Token': $('input[name="_token"]').val()
      }
    });
    $.ajax({
      type: "POST",
      url: "http://{{request()->getHttpHost()}}/api/mapeo/observaciones/ingresar",
      data: JSON.stringify(datos),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (data, status, jqXHR) {
        // do something
        $mensaje.removeClass('hidden');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        console.log(data.msg);
      },
      error: function (jqXHR, status) {
        // error handler
        console.log("no funco");
      }

    });
  }

  function replaceSpace(texto){
    var res = texto.replace(/\n/gi, "</br>");
    return res;
  }
  </script>

@endsection
