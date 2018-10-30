@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading">Ingreso de Materias</div>
        <div class="panel-body">
          <form action="{{URL::to('/gestionar/ingreso-materias/listar')}}" method="GET" class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3">
                  Carrera
                </label>
                <div class="col-md-9">
                  <select id="carrera" class="form-control" name="carrera" onchange="actualizarAreas()" required>
                    <option value="">Seleccione una carrera</option>
                    @foreach ($carreras as $carrera)
                      @if($carrera->codigo == Auth::user()->career || Auth::user()->type == 99)
                        <option value="{{$carrera->codigo}}">{{$carrera->nombre}}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">
                  Area
                </label>
                <div class="col-md-9">
                  <select id="area-form" class="form-control" name="area" disabled>
                    <option value="">Ninguno</option>
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
@section('scripts')
<script>
  function actualizarAreas(){
    var carrera = document.getElementById('carrera');
    var sel = document.getElementById('area-form');
    sel = ClearOptionsFast('area-form');
    var opt = document.createElement('option');
    opt.innerHTML = "Ninguno";
    opt.value = "";
    sel.appendChild(opt);
    cargarDatos(carrera.value);
  }
  function cargarDatos(id){
    var sel = document.getElementById('area-form');
    sel.disabled = true;
    $.ajax({
      type: "GET",
      url: "http://{{request()->getHttpHost()}}/api/materia/areas/" + id,
      contentType: "application/json; charset=utf-8",
      success: function (data, status, jqXHR) {
        // do something
        for(var i = 0; i < data.length; i++) {
            var opt = document.createElement('option');
            opt.innerHTML = data[i].descripcion;
            opt.value = data[i].id;
            sel.appendChild(opt);
            sel.disabled = false;
        }
      },
      error: function (jqXHR, status) {
        // error handler
        console.log("no funco");
      }

    });
  }
  function ClearOptionsFast(id)
  {
    var selectObj = document.getElementById(id);
    var selectParentNode = selectObj.parentNode;
    var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
    selectParentNode.replaceChild(newSelectObj, selectObj);
    return newSelectObj;
  }
</script>
@endsection
