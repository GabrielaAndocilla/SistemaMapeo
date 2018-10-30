<?php

Route::group(['middleware' => ['auth','no-cache'],'prefix' => 'rest'], function () {

  Route::get('materia/siglas/{id}','MateriaController@siglas');
  Route::get('materia/areas/{id}','MateriaController@areas');

  Route::get('materia/sobrecarga/{id}','ReporteController@apiSobrecargaRdaCarrera');

  Route::get('materia/especializacion/{id}', 'MateriaController@apiMateria');
  Route::get('materia/generales/{id}', 'MateriaController@apiMateriaGeneral');

  Route::post('mapeo/observaciones/ingresar', 'MapeoController@addObservaciones');

  Route::get('materia', 'Api\SubjectController@index');
  Route::post('materia', 'Api\SubjectController@store');
  Route::put('materia/{id}', 'RdaPeriodoController@update');
  Route::delete('materia/{id}', 'RdaPeriodoController@destroy');

  Route::get('area/{id}', 'AreaController@apiListarAreas');
  
  Route::get('materia/especializacion/{carrera}/a/{area}', 'MateriaController@apiMateriaByArea');

  Route::get('materia/{id}','RdaPeriodoController@show');
});

Route::group(['middleware' => ['auth','no-cache']], function () {

  Route::get('materia/siglas/{id}','MateriaController@siglas');
  Route::get('materia/areas/{id}','MateriaController@areas');

  Route::get('materia/sobrecarga/{id}','ReporteController@apiSobrecargaRdaCarrera');

  Route::get('materia/especializacion/{id}', 'MateriaController@apiMateria');
  Route::get('materia/generales/{id}', 'MateriaController@apiMateriaGeneral');

  Route::post('mapeo/observaciones/ingresar', 'MapeoController@addObservaciones');

  Route::get('materia', 'Api\SubjectController@index');
  Route::post('materia', 'Api\SubjectController@store');
  Route::put('materia/{id}', 'RdaPeriodoController@update');
  Route::delete('materia/{id}', 'RdaPeriodoController@destroy');

  Route::get('area/{id}', 'AreaController@apiListarAreas');
  
  Route::get('materia/especializacion/{carrera}/a/{area}', 'MateriaController@apiMateriaByArea');

  Route::get('materia/{id}','RdaPeriodoController@show');
});
