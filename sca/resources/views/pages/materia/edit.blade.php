@extends('app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('/css/dropzone.css')}}">

<?php $materia = $data["materia"];

function replaceInverse($texto){
  return str_replace("</br>","\n",$texto);
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{$materia->careerSignature->signature->nombre_materia.' - '.$materia->careerSignature->signature->codigo_materia}}</div>
        <div class="panel-body">
          <div id="result" class="alert alert-success hidden">Se ha guardado exitosamente!</div>
          <div id="error-rda" class="alert alert-danger hidden"></div>
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
          @if (isset($data["pdfUploaded"]))
          @if ($data["pdfUploaded"])
          <div class="alert alert-success">Se ha subido exitosamente!</div>
          @endif
          @endif


                    @if(Session::has('success'))
                      <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif

          @if(Session::has('warning'))
            <div class="alert alert-warning">{{Session::get('warning')}}</div>
          @endif


          @if(Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
          @endif
          <div class="row form-group">
            <div class="col-md-12">
              <label>Período Actual:</label>
              {{$materia->periodo}}
            </div>
          </div>



          @if($materia->silabo != null || $materia->silabo != "")
          <div class="row form-group">
            <label class="col-md-2 control-label">Subir sílabo:</label>
            <div class="col-md-10">
              <form class="form-horizontal" method="GET" action="{{URL::to('/materia').'/'.$materia->careerSignature->cod_materia.'/'.$materia->careerSignature->cod_carrera.'/eliminarSilabo'}}"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-danger" name="eliminar" value="Eliminar Sílabo">
              </form>
            </div>
          </div>
          @else
          <div class="row form-group">
            <label class="col-md-2 control-label">Subir sílabo:</label>
            <div class="col-md-10">
              <form class="dropzone" id="silabos-dropzone" method="POST" action="{{URL::to('/materia').'/'.$materia->careerSignature->cod_materia.'/'.$materia->careerSignature->cod_carrera.'/edit'}}"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="fallback">
                  <input type="file" name="file" required>
                </div>
              </form>
            </div>
          </div>
          @endif
          <form class="form-horizontal" method="POST" action="{{URL::to('/materia').'/'.$materia->careerSignature->cod_materia.'/'.$materia->careerSignature->cod_carrera.'/observaciones'}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-2">
                Observación General del sílabo:
              </label>
              <div class="col-md-10">
                <input type="text" class="form-control" name="observacion" value="{{$materia->observacion}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2">
                Responsables
              </label>
              <div class="col-md-10">
                <input type="text" class="form-control" name="responsables" value="{{$materia->responsables}}">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-2 col-md-4">
                <input type="submit" class="btn btn-primary" name="submit" value="Añadir Observación">
              </div>
            </div>
          </form>
          <form class="form-horizontal" method="POST" action="{{URL::to('/materia').'/'.$materia->careerSignature->cod_materia.'/edit'}}" >

            @if($materia->categoria!= 1)

            <div class="form-group">
              <div class="col-md-12">
                <div class="udla-add-header">
                  <label>RDAs y MDEs</label>
                  <button type="button" class="table-add">+ Añadir</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div id="table" class="table-editable table-responsive">
                    <table id="rda-mde-table-view" class="table" style="table-layout:fixed;">
                      <col width="22%">
                      <col width="22%">
                      <col width="11%">
                      <col width="9%">
                      <col width="15%">
                      <col width="11%">
                      <col width="5%">
                      <col width="5%">
                      <thead>
                        <th>RDA carrera</th>
                        <th>RDA materia</th>
                        <th>MDE</th>
                        <th>Nivel</th>
                        <th>Observaciones</th>
                        <th>Responsables</th>
                        <th></th>
                        <th></th>
                      </thead>
                      @foreach( $data["rda"] as $rda)
                      <!-- This is our clonable table line -->
                      <tr>
                        <td>
                          <select class="form-control">
                            <option value="" >Ninguno</option>
                            @foreach( $data["rdaCarrera"] as $rdaC)
                            @if($rda->rda_carrera_id == $rdaC->id)
                            <option value="{{ $rdaC->id }}" selected>{{ $rdaC->rda_carrera }}</option>
                            @else
                            <option value="{{ $rdaC->id }}">{{ $rdaC->rda_carrera }}</option>
                            @endif
                            @endforeach
                          </select>
                        </td>
                        <td contenteditable="true" class="wrapword">{{replaceInverse($rda->rda)}}</td>
                        <td contenteditable="true" class="wrapword">{{replaceInverse($rda->mde)}}</td>
                        <td>
                          <select name="nivel" class="form-control">
                            @if($rda->nivel == 1)
                            <option value="1" selected>Inicial</option>
                            @else
                            <option value="1">Inicial</option>
                            @endif
                            @if($rda->nivel == 2)
                            <option value="2" selected>Medio</option>
                            @else
                            <option value="2">Medio</option>
                            @endif
                            @if($rda->nivel == 3)
                            <option value="3" selected>Final</option>
                            @else
                            <option value="3">Final</option>
                            @endif
                          </select>
                        </td>
                        <td contenteditable="true" class="wrapword">{{replaceInverse($rda->observaciones)}}</td>
                        <td contenteditable="true" class="wrapword">{{replaceInverse($rda->responsables)}}</td>
                        <td>
                          <span class="table-remove glyphicon glyphicon-remove"></span>
                        </td>
                        <td>
                          <span class="table-up glyphicon glyphicon-arrow-up"></span>
                          <span class="table-down glyphicon glyphicon-arrow-down"></span>
                        </td>
                      </tr>
                      @endforeach
                      <tr class="hide">
                        <td>
                          <select class="form-control">
                          <option value="0" >Ninguno</option>
                            @foreach( $data["rdaCarrera"] as $rdaC)
                            <option value="{{ $rdaC->id }}">{{ $rdaC->rda_carrera }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td contenteditable="true" class="wrapword">[Vacío]</td>
                        <td contenteditable="true" class="wrapword">[Vacío]</td>
                        <td>
                          <select name="nivel" class="form-control">
                            <option value="1">Inicial</option>
                            <option value="2">Medio</option>
                            <option value="3">Final</option>
                          </select></td>
                          <td contenteditable="true" class="wrapword">Sin observaciones</td>
                          <td contenteditable="true" class="wrapword"></td>
                          <td>
                            <span class="table-remove glyphicon glyphicon-remove"></span>
                          </td>
                          <td>
                            <span class="table-up glyphicon glyphicon-arrow-up"></span>
                            <span class="table-down glyphicon glyphicon-arrow-down"></span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <button type="button" class="btn btn-default" onclick="window.history.back();"><span class="glyphicon glyphicon-chevron-left"></span>Atrás</button>
                  <button type="button" class="btn btn-primary" onclick="saveRda({{$materia->id, csrf_token()}})">Guardar</button>
                </div>
                <label id="export"></label>
              </div>
              @endif

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

  @section('scripts')
  <script src="{{URL::to('js/dropzone.js')}}"></script>
  <script src="{{URL::to('js/main.js')}}"></script>
  <script>
  $DROPZONE = document.getElementById("silabos-dropzone");

  function saveRda($id,$token){
    var $rows = $TABLE.find('tr:not(:hidden)');
    var headers = [];
    var data = [];
    var datos = {};
    var $mensaje = $('#result');

    // Get the headers (add special header logic here)
    $($rows.shift()).find('th:not(:empty)').each(function () {
      headers.push($(this).text().toLowerCase());
    });

    // Turn all existing rows into a loopable array
    $rows.each(function () {
      var $td = $(this).find('td');
      var h = {};
      // Use the headers from earlier to name our hash keys
      headers.forEach(function (header, i) {
        if($td.eq(i).find('select.form-control').length){
          h[header] = $td.eq(i).find('select.form-control').val();
        }else{
          h[header] = replaceSpace($td.eq(i).text());
        }
      });
      data.push(h);

    });
    datos = {
      perido_m: $id,
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
        url: "http://{{request()->getHttpHost()}}/api/materia",
        data: JSON.stringify(datos),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data, status, jqXHR) {
          // do something
          $mensaje.removeClass('hidden');
          $('#error-rda').addClass('hidden');
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          console.log(data.msg);
        },
        error: function (data,status, jqXHR) {
          $mensaje.addClass('hidden');
          $('#error-rda').removeClass('hidden').text(data.responseJSON.msg);
          $('html, body').animate({ scrollTop: 0 }, 'slow');
        }

      });
    }

    function replaceSpace(texto){
      var res = texto.replace(/\n/gi, "</br>");
      return res;
    }

    $DROPZONE.on("addedfile", function(file) {
      file.previewElement.addEventListener("click", function() {
        myDropzone.removeFile(file);
      });
    });


    </script>
    @endsection
