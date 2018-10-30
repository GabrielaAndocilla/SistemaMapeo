<?php
function decodeHtmlEnt($str) {
    $ret = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
    $p2 = -1;
    for(;;) {
        $p = strpos($ret, '&#', $p2+1);
        if ($p === FALSE)
            break;
        $p2 = strpos($ret, ';', $p);
        if ($p2 === FALSE)
            break;
            
        if (substr($ret, $p+2, 1) == 'x')
            $char = hexdec(substr($ret, $p+3, $p2-$p-3));
        else
            $char = intval(substr($ret, $p+2, $p2-$p-2));
            
        //echo "$char\n";
        $newchar = iconv(
            'UCS-4', 'UTF-8',
            chr(($char>>24)&0xFF).chr(($char>>16)&0xFF).chr(($char>>8)&0xFF).chr($char&0xFF) 
        );
        //echo "$newchar<$p<$p2<<\n";
        $ret = substr_replace($ret, $newchar, $p, 1+$p2-$p);
        $p2 = $p + strlen($newchar);
    }
    return $ret;
}
?>
@extends('app')

@section('content')
<div class="container">
	<h1>{{$data->nombre}}</h1>

	<hr>
	<br>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<label><b>Guía de la Carrera:</b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<label>Título:</label>
		</div>
		<div class="col-sm-10">
			{{$data->titulo}}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<label>Duración:</label>
		</div>
		<div class="col-sm-10">
			{{$data->duracion}} semestres
		</div>
	</div>
		<div class="row">
		<div class="col-sm-2">
			<label>Modalidad:</label>
		</div>
		<div class="col-sm-10">
			Pregados, Posgrado Diurno
		</div>
	</div>
	<br>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<label><b>Orientación de la carrera:</b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo decodeHtmlEnt($data->orientacion_de_carrera); ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<label><b>Ventajas:</b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo decodeHtmlEnt($data->ventajas); ?>
		</div>
	</div>
		<br>
	<div class="row">
		<div class="col-sm-12">
			<label><b>Competencias y habilidad:</b></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php echo decodeHtmlEnt($data->competencias); ?>
		</div>
	</div>
</div>
@endsection
