<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
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

<style type="text/css">
  th,td{
    width: 20;
  }
  tr > td {
    border-bottom: 1px solid #000000;
}
  .rowhide{
    display:none !important;
  }
</style>

<table  cellpadding="0" cellspacing="0" style="font-size:9px;" class="tablesaw table table-bordered" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
  <thead>
  <caption><h1 align='center'>Mapeo RdA de carrera versus RdA Institucional</h1></caption>
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
              <p align="center">X</p>
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
<table border="1"  class="table table-bordered">
    <tr></tr>
    <tr>
      <td>Elaborado por</td>
      <td>Aprobado por</td>
      <td>Revisado por</td>
      @for($j=0;$j < 8 ;$j++)
        <td></td>
      @endfor
    </tr>
    <tr>
      @for($j=0;$j < 11 ;$j++)
        <td></td>
      @endfor
    </tr>
  </table>
<!-- End Table -->
</body>
</html>