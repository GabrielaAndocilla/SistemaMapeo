@extends('pdf.pdf')
@section('content')
<style>
.rowhide{
  display:none !important;
}
</style>

<?php $materias = $datos["materias"]; ?>
<?php $semestres = $datos["semestres"]; ?>
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

<h1 align='center'>Mapeo Curricular de la Carrera</h1>


<table style="font-size:9px;">
  <thead>
    <tr>
      <th rowspan="2" valign="middle" class="headcol" >RDA INSTITUCIONALES</th>
      <th rowspan="2" valign="middle" class="headcol"  >PERFIL DE CARRERA/ASIGNATURAS</th>
      @foreach($semestres as $semestre)
      <th colspan="2">Semestre {{ $semestre->semestre}}</th>
      @endforeach
      <th rowspan="2" valign="middle" class="headcol" class="observaciones-title"   >Observaciones</th>
    </tr>
    <tr >
      <?php $i_f=0;?>
      @foreach($materias as $materia)
      <th colspan="2"    >{{ $materia->nombre_materia}}</th>
      <?php $i_f++;?>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <tr>
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
          <li>{{$rus->rda_universidad_abrev}}</li>
          @endif
          @endforeach
        </ul>
      </td>
      <td class="row-rda">{{$datos["rdaCarreras"][$i]->nombre}}</td>
      @for($j=0;$j < count($materias) ;$j++)
      @if(count($materias[$j]->rdaCarrera[$i]->rdaMateria) > 0)
      <td>
        @foreach($materias[$j]->rdaCarrera[$i]->rdaMateria as $rdaM)
        {!!$rdaM->rda . "<br /><br/>"!!}
        @endforeach
      </td>
      <td>
        @foreach($materias[$j]->rdaCarrera[$i]->rdaMateria as $rdaM)
        {!!$rdaM->mde . "<br /><br />"!!}
        @endforeach
      </td>
      @else
      <td></td>
      <td></td>
      @endif
      @endfor

      @if($i < count($datos["observaciones"]))
      <td style="background: #FCFFD2 !important;"  class="observaciones wrapword">{{$datos["observaciones"][$i]->observaciones}}</td>
      @else
      <td style="background: #FCFFD2 !important;" class="observaciones wrapword"></td>
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

@endsection
