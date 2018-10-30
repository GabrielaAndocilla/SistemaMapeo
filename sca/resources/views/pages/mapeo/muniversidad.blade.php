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
?>
<div class="container-fluid">
  <div class="card">
    <div class="row">
      <caption><h1 align='center'>Mapeo RdA de carrera versus RdA Institucional</h1></caption>
        <div class='col-md-12 sca-exportar'>
            <a href="{{URL::to('mapeocarrera').'/'.$datos['carrera'].'/exportar'}}">
              <button type="button" class="btn btn-success">
                <span class="glyphicon glyphicon-export"></span> Excel
              </button>
            </a>
        </div>
    </div>
      <div class="row">
      <!-- Begin Table -->
      <div class="table-responsive">
        <table  cellpadding="0" cellspacing="0" style="font-size:9px;" class="tablesaw table table-bordered" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
          <thead>          
            <tr scope="row" data-tablesaw-sortable-row data-tablesaw-priority="persist">
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">UNIVERSIDAD/PERFIL DE CARRERA</th>
              <?php $i_f=0;?>
              @foreach($datos["rdaUniversidad"] as $rdaU)
              <th data-tablesaw-sortable-col data-tablesaw-priority="{{ $i_f }}">{{ $rdaU->rda_universidad}}</th>
              <?php $i_f++;?>
              @endforeach
              <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Observaciones</th> -->
            </tr>
          </thead>
          <tbody>
            @for($i=0;$i < count($datos["rdaCarreras"]);$i++)
            <tr>
              <td class="row-rda">{{$datos["rdaCarreras"][$i]->rda_carrera}}</td>
              @for($j=0;$j < count($datos["rdaUniversidad"]) ;$j++)
                @if(count($datos["rdaUniversidadxCarrera"]) > 0 )
                  <td align="center" valign="middle">
                  @foreach($datos["rdaUniversidadxCarrera"] as $ruc)
                    @if($ruc->id == $datos["rdaCarreras"][$i]->id)
                      @if($ruc->idUniversidad == $datos["rdaUniversidad"][$j]->id)
                      <div class="pintado"></div>
                      @endif
                    @endif
                  @endforeach
                  </td>
                @else
                <td></td>
                @endif
              @endfor
              <!-- <td class"selectable"></td> -->
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
<script src="{{URL::to('/js/tablesaw.js')}}"></script>

@endsection
