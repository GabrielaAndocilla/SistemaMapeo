@extends('pdf.pdf')
@section('content')

<h1>Tabla de resumen de asignaturas que aportan a los resultados de aprendizaje de carrera e institucional</h1>
<h3 align='center'>{{Utils::getCarrera($datos['carrera'])->nombre}}</h3>
<table border='1'>
  <col width="33.33%">
  <col width="33.33%">
  <col width="33.33%">
    <tr>
      <th>Resultados de Aprendizaje Institucionales</th>
      <th>Resultados de Aprendizaje de la Carrera</th>
      <th>Materias que Aportan al Resultados de Aprendizaje de la Carrera</th>
    </tr>
    <tbody>
      @foreach($datos["rdaUniversidad"] as $ru)
        <tr>
          <td>{{$ru->rda_universidad}}</td>
          <td>
            <ul>
              @foreach($datos["rdaCarrera"] as $ra)
              @foreach($datos["rdaUniCarrera"] as $ruc)
            @if($ra->id == $ruc->rda_carrera_id && $ru->id == $ruc->rda_universidad_id)
              <li>{{$ra->rda_carrera}}</li>
            @endif
            @endforeach
            @endforeach
          </ul>
          </td>
          <td>
            <ul>
            @foreach($datos["materias"] as $materia)
            @if($ru->id == $materia->id)
            <li>{{$materia->nombre_materia}}</li>
            @endif
            @endforeach
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
</table>
@endsection
