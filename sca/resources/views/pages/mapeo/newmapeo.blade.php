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
    return "Alto";
    break;

    default:
    # code...
    return "";
    break;
  }
}

function cutText($string){
  $ret = $string;
  if(strlen($string) > 35){
    $ret = substr($string, 0, 34).'...';
  }
  return $ret;
}
?>
<div class="container-fluid">
  <div class="card">
      <div id="result" class="alert alert-success hidden">Se ha guardado exitosamente!</div>
    <div class="row">
        <h1 align='center'>Mapeo Curricular de la Carrera</h1>
      <div class="col-sm-10">
        <button onclick="saveRda({{1, csrf_token()}})" type="button" class="btn btn-primary">Actualizar</button>
          <label id="export"></label>
      </div>
    </div>
    <div class="row">
      <!-- Begin Table -->
      <div id="table" class="table-editable table-responsive table-mapeo">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
              <td></td>
            </tr>
            <tr>
              <td>Tipo de Asignatura</td>
              @foreach($materias as $materia)
              <td colspan="2">Obligatoria</td>
              <td class="rowhide"></td>
              @endforeach
              <td></td>
            </tr>
            <tr>
              <td>Área de formación</td>
              @foreach($materias as $materia)
              <td colspan="2">{{$materia->area}}</td>
              <td class="rowhide"></td>
              @endforeach
              <td></td>
            </tr>
            <tr>

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
              <td></td>
            </tr>
            <!-- Plantilla -->
            <tr>

              <td></td>
              @for($j=0;$j < count($materias) ;$j++)

              <td><b>RDA:</b></td>
              <td><b>MDE:</b></td>

              @endfor
              <td></td>
            </tr>

            <!-- End plantilla -->
            @for($i=0;$i < count($datos["rdaCarreras"]);$i++)
            <tr>
              <td>
                <ul>
                @foreach($datos["rdaUniversidad"] as $rus)
                @if($rus->id == $datos["rdaCarreras"][$i]->id)
                <li>{{cutText($rus->rda_universidad)}}</li>
                @endif
                @endforeach
                </ul>
              </td>
              <td class="row-rda">{{$datos["rdaCarreras"][$i]->nombre}}</td>
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

              @if($i < count($datos["observaciones"]))
                <td style="background: #FCFFD2 !important;" contenteditable="true" class="observaciones wrapword">{{$datos["observaciones"][$i]->observaciones}}</td>
              @else
                <td style="background: #FCFFD2 !important;" contenteditable="true" class="observaciones wrapword"></td>
              @endif
            </tr>
            <tr>
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
              <td></td>
            </tr>
            @endfor
          </tbody>
        </table>
        <!-- End Table -->
      </div>
    </div> <!-- End Card -->
  </div>
</div>
@endsection
@section('scripts')
<script src="{{URL::to('/js/qunit.js')}}"></script>

<!--[if lt IE 9]><script src="{{URL::to('/js/respond.js')}}"></script><![endif]-->
<script src="{{URL::to('/js/scamapeotable.js')}}"></script>


<script>

var $TABLE = $('#table');
var $EXPORT = $('#export');

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

function saveRda($id,$token){
  //var $rows = $TABLE.find('.observaciones');
  var headers = [];
  var data = [];
  var datos = {};
  var $mensaje = $('#result');

  // Get the headers (add special header logic here)
  //$($rows.shift()).find('th:not(:empty)').each(function () {
  $('.observaciones').each(function() {
    headers.push("observaciones");
  });

  // Turn all existing rows into a loopable array
//  $rows.each(function () {
    var $td = $('.observaciones');
    console.log($td.eq(0).text());
    var h = {};
    // Use the headers from earlier to name our hash keys
    headers.forEach(function (header, i) {
      //if($td.eq(i).find('select.form-control').length){
        //h[header] = $td.eq(i).find('select.form-control').val();
      //}else{
        h[i] = replaceSpace($td.eq(i).text());
      //}
    });
    data.push(h);

  //});
  datos = {
    carrera: $id,
    datos: data
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
