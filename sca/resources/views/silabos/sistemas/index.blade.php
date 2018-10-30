<?php
$path = "silabospdf/especializacion";
$periodo = $actual_periodo['codigo'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Malla Académica de Ingeniería Ambiental en Prevención y Remediación</title>
</head>
<body>
  <img src="{{asset('images/silabos/1.jpg')}}" alt="MallaSistemas" width="1772" height="1240" usemap="#Map" longdesc="https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-xfa1/t1.0-9/998291_565658363493752_1954369723_n.jpg" border="0" />
  <map name="Map" id="Map"><area shape="rect" coords="781,1097,895,1149" href="{{URL::to($path)}}/1_ING300_{{$periodo}}.pdf" target="_blank" alt="EIA110" /><area shape="rect" coords="904,1097,1018,1149" href="{{URL::to($path)}}/1_ING400_{{$periodo}}.pdf" target="_blank" alt="EIA110" /><area shape="rect" coords="1026,1097,1140,1149" href="{{URL::to($path)}}/1_ING500_{{$periodo}}.pdf" target="_blank" alt="EIA110" /><area shape="rect" coords="538,228,652,280" href="{{URL::to($path)}}/1_ACI220_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="660,227,774,279" href="{{URL::to($path)}}/1_ACI320_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="782,228,896,280" href="{{URL::to($path)}}/1_ACI421_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="904,227,1018,279" href="{{URL::to($path)}}/1_ACI520_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1026,228,1140,280" href="{{URL::to($path)}}/1_ACI620_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1149,227,1263,279" href="{{URL::to($path)}}/1_ACI850_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1271,227,1385,279" href="{{URL::to($path)}}/1_ACI880_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1393,226,1507,278" href="{{URL::to($path)}}/1_ACI040_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1512,227,1626,279" href="{{URL::to($path)}}/1_ACI030_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="416,288,530,340" href="{{URL::to($path)}}/1_ACI120_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="782,288,896,340" href="{{URL::to($path)}}/1_ACI480_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="905,288,1019,340" href="{{URL::to($path)}}/1_ACI530_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1027,289,1141,341" href="{{URL::to($path)}}/1_ACI630_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1150,288,1264,340" href="{{URL::to($path)}}/1_ACI770_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1270,288,1384,340" href="{{URL::to($path)}}/1_ACI920_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1393,289,1507,341" href="{{URL::to($path)}}/1_ACI961_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1514,289,1628,341" href="{{URL::to($path)}}/1_ACI840_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1026,352,1140,404" href="{{URL::to($path)}}/1_ACI760_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1149,352,1263,404" href="{{URL::to($path)}}/1_ACI860_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="418,415,532,467" href="{{URL::to($path)}}/1_ACI110_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="538,415,652,467" href="{{URL::to($path)}}/1_ACI280_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="660,415,774,467" href="{{URL::to($path)}}/1_ACI640_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="783,415,897,467" href="{{URL::to($path)}}/1_ACI740_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="904,415,1018,467" href="{{URL::to($path)}}/1_IER402_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1271,415,1385,467" href="{{URL::to($path)}}/1_ACI010_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1393,415,1507,467" href="{{URL::to($path)}}/1_Silabo_2014_-_2_EIA110-1.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="905,477,1019,529" href="{{URL::to($path)}}/1_ACI580_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1026,477,1140,529" href="{{URL::to($path)}}/1_ACI680_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1515,540,1629,592" href="{{URL::to($path)}}/1_ACI090_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1148,540,1262,592" href="{{URL::to($path)}}/1_ACI050_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1272,540,1386,592" href="{{URL::to($path)}}/1_ACI810_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1393,540,1507,592" href="{{URL::to($path)}}/1_ACI980_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="416,228,530,280" href="{{URL::to($path)}}/1_ACI131_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1147,602,1261,654" href="{{URL::to($path)}}/1_EIA760_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1271,602,1385,654" href="{{URL::to($path)}}/1_ACI870_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1393,602,1507,654" href="{{URL::to($path)}}/1_ACI830_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1515,601,1629,653" href="{{URL::to($path)}}/1_MET511_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="416,662,530,714" href="{{URL::to($path)}}/1_CAD100_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="538,662,652,714" href="{{URL::to($path)}}/1_EIP521_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="659,662,773,714" href="{{URL::to($path)}}/1_IER202_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="783,662,897,714" href="{{URL::to($path)}}/1_IES541_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="905,662,1019,714" href="{{URL::to($path)}}/1_IES340_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="782,723,896,775" href="{{URL::to($path)}}/1_IES640_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="904,722,1018,774" href="{{URL::to($path)}}/1_ACI360_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="782,784,896,836" href="{{URL::to($path)}}/1_MAT410_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="539,783,653,835" href="{{URL::to($path)}}/1_MAT210_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="659,783,773,835" href="{{URL::to($path)}}/1_MAT310_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1027,540,1141,592" href="{{URL::to($path)}}/1_ACI650_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="416,843,530,895" href="{{URL::to($path)}}/1_MAT110_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="538,843,652,895" href="{{URL::to($path)}}/1_MAT221_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="661,843,775,895" href="{{URL::to($path)}}/1_AES300_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="416,904,530,956" href="{{URL::to($path)}}/1_FIS100_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="904,968,1018,1020" href="{{URL::to($path)}}/1_AEA111_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1027,968,1141,1020" href="{{URL::to($path)}}/1_FIC650_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="1148,968,1262,1020" href="{{URL::to($path)}}/1_EIP740_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="538,1033,652,1085" href="{{URL::to($path)}}/1_AEA132_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="660,1034,774,1086" href="{{URL::to($path)}}/1_AEA340_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="538,1097,652,1149" href="{{URL::to($path)}}/1_ING100_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="660,1097,774,1149" href="{{URL::to($path)}}/1_ING200_{{$periodo}}.pdf" target="_blank" alt="EIA110" />
    <area shape="rect" coords="415,784,529,836" href="{{URL::to($path)}}/1_MAT000_{{$periodo}}.pdf" target="_blank" alt="EIA110" />

  </map>
</body>
</html>
