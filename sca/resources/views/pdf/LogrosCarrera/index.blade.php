@extends('pdf.pdf')
@section('content')
<h2 align='center'>Matriz en cascada de los Resultados de aprendiza y Estándares de Logro Institucionales VS Carrera</h2>
<h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
<table class="table table-bordered">
    <col width="25%">
    <col width="25%">
    <col width="25%">
    <col width="25%">
    <tr>
      <th>Resultados de Aprendizaje Institucionales</th>
      <th>Resultados de Aprendizaje de la Carrera</th>
      <th>Estándares de Logros de RdA Institucionales</th>
      <th>Estándares de Logros de RdA de la Carrera</th>
    </tr>
    <tbody>
      @foreach($datos["rdaUniversidad"] as $ru)
        <tr>
          <td>{{$ru->rda_universidad}}</td>
          <td>
            @foreach($datos["rdaCarrera"] as $ra)
              @foreach($datos["rdaUniCarrera"] as $ruc)
                @if($ra->id == $ruc->rda_carrera_id && $ru->id == $ruc->rda_universidad_id)
                  {{$ra->rda_carrera}}
                @endif
              @endforeach
            @endforeach
          </td>
          <td>
            @if($ru->id)
              {{$ru->logros}}
            @endif
          </td>
          <td>
          @foreach($datos["logrosCarrera"] as $rucl)
            @if($rucl->rda_uni_id== $ru->id)
              {{$rucl->logro_carrera}}
            @endif
          @endforeach
          </td>
        </tr>
      @endforeach
    </tbody>
</table>
@endsection
