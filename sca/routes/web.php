<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::group(['middleware' => ['auth','no-cache']], function () {
  Route::get('campasswd','Auth\PasswordController@index');
  Route::get('inicio', 'HomeController@index');
  Route::get('mapeo/{id}', 'MapeoController@index');
  Route::get('mapeo/{id}/{periodo}', 'MapeoController@withPeriodo');
  Route::post('mapeo/{id}', 'MapeoController@addObservacion');
  Route::get('nuevomapeo/{id}', 'MapeoController@newMapeo');
  Route::get('mapeo', 'MapeoController@consultar');
  Route::post('mapeo','MapeoController@routeCarrera');
  Route::get('mapeo/{id}/{periodo}/exportar', 'MapeoController@exportar');
  Route::get('mapeo/{id}/pdf/exportar', 'ExportarController@mapeo');
  Route::get('mapeocarrera/{id}/exportar', 'MapeoController@mapeoCarreraExcel');
  Route::get('mapeocarrera/{id}/{periodo}', 'MapeoController@mapeoCarrera');
  Route::get('materias/generales', 'MateriaController@generalesConsulta');
  Route::post('materias/generales', 'MateriaController@routeGenerales');
  Route::get('materias/generales/{id}', 'MateriaController@mostrarGenerales');
  Route::get('materias/especializacion', 'MateriaController@listEspecializacion');
  Route::get('materias/especializacion/{id}', 'MateriaController@index');
  Route::get('materia/{id}/{carrera}/edit', 'MateriaController@edit');
  Route::get('materia/{id}/{carrera}/eliminarSilabo', 'MateriaController@eliminarSilabo');
  Route::post('materia/{id}/{carrera}/observaciones', 'MateriaController@observacion');
  Route::post('materia/{id}/{carrera}/edit', 'MateriaController@uploadPDF');
  Route::post('materia/{id}/edit/profesor', 'MateriaController@updateEncargado');

  /* ---------------------------------------------------------
   *  Gestionar sílabos graficos
   * --------------------------------------------------------*/
  Route::get('/gestionar/silabosgraficos', 'SilaboController@consultar');
  Route::get('/gestionar/silabosgraficos/mostrar', 'SilaboController@mostrarSilabos');
  /* ---------------------------------------------------------
   *  CRUD AREAS
   * --------------------------------------------------------*/
  Route::get('/gestionar/areas', 'AreaController@consultar');
  Route::get('/gestionar/areas/{id}/insertar', 'AreaController@create');
  Route::post('/gestionar/areas/{id}/insertar', 'AreaController@store');
  Route::get('/gestionar/areas/{id}/editar', 'AreaController@edit');
  Route::post('/gestionar/areas/{id}/editar', 'AreaController@update');
  Route::get('/gestionar/areas/{id}/eliminar', 'AreaController@destroy');
  Route::get('/gestionar/areas/listar', 'AreaController@index');


  /* ---------------------------------------------------------
   *  CRUD MATERIAS
   * --------------------------------------------------------*/
  Route::get('/gestionar/ingreso-materias', 'MateriaController@consultar');
  Route::get('/gestionar/ingreso-materias/{id}/insertar', 'MateriaController@ingreso');
  Route::post('/gestionar/ingreso-materias/{id}/insertar', 'MateriaController@ingresar');
  Route::get('/gestionar/ingreso-materias/{id}/editar','MateriaController@editar');
  Route::post('/gestionar/ingreso-materias/{id}/editar','MateriaController@update');
  Route::get('/gestionar/ingreso-materias/{id}/eliminar', 'MateriaController@destroy');
  Route::get('/gestionar/ingreso-materias/listar', 'MateriaController@listar');

  /* ---------------------------------------------------------
   *  CRUD RDA Carrera
   * --------------------------------------------------------*/
  Route::get('/gestionar/rda-carreras/{id}/insertar', 'RdaCarreraController@guardado');
  Route::post('/gestionar/rda-carreras/{id}/insertar', 'RdaCarreraController@guardar');
  Route::get('/gestionar/rda-carreras', 'RdaCarreraController@consultar');
  Route::get('/gestionar/rda-carreras/{id}/editar', 'RdaCarreraController@edit');
  Route::post('/gestionar/rda-carreras/{id}/editar', 'RdaCarreraController@update');
  Route::get('/gestionar/rda-carreras/{id}/eliminar', 'RdaCarreraController@destroy');
  Route::get('/gestionar/rda-carreras/listar', 'RdaCarreraController@index');


  /*---------------------------------------------------------
   *  CRUD Estandares de logro Carrera
   * --------------------------------------------------------*/
  Route::get('/gestionar/ingreso-logros-carrera', 'RdaCarreraController@consulta_logros');
  Route::get('/gestionar/ingreso-logros-carrera/mostrar', 'RdaCarreraController@mostrar_logros');
  Route::get('/gestionar/ingreso-logros-carrera/{id}/insertar', 'RdaCarreraController@insertar_logros');
  Route::post('/gestionar/ingreso-logros-carrera/{id}/insertar', 'RdaCarreraController@store_logro');
  Route::get('/gestionar/ingreso-logros-carrera/{id}/eliminar', 'RdaCarreraController@destroy_logro');
  Route::get('/gestionar/ingreso-logros-carrera/{id}/editar', 'RdaCarreraController@editar_logros');
  Route::post('/gestionar/ingreso-logros-carrera/{id}/editar', 'RdaCarreraController@update_logros');
  /* ---------------------------------------------------------
   *  CRUD RDA Universidad
   * --------------------------------------------------------*/
  Route::get('/gestionar/rda-universidad/insertar', 'RdaUniversidadController@create');
  Route::post('/gestionar/rda-universidad/insertar', 'RdaUniversidadController@store');
  Route::get('/gestionar/rda-universidad/{id}/editar', 'RdaUniversidadController@edit');
  Route::post('/gestionar/rda-universidad/{id}/editar', 'RdaUniversidadController@update');
  Route::get('/gestionar/rda-universidad/{id}/eliminar', 'RdaUniversidadController@destroy');
  Route::get('/gestionar/rda-universidad', 'RdaUniversidadController@index');
  /* ---------------------------------------------------------
   *  CRUD Reportes
   * --------------------------------------------------------*/
  Route::get('/reportes/reportes-general-con-logros', 'ReporteController@generalConLogros');
  Route::get('/reportes/reportes-general-con-logros/mostrar', 'ReporteController@generalConLogrosShow');
  Route::get('/reportes/reportes-general-con-logros/exportar', 'ExportarController@generalConLogrosShowExcel');
  Route::get('/reportes/reportes-general-con-logros/pdf/exportar', 'ExportarController@generalConLogrosShow');
  Route::get('/reportes/reportes-carrera', 'ReporteController@show');
  Route::get('/reportes/reportes-carrera/mostrar', 'ReporteController@mostrar');
  Route::get('/reportes/reportes-carrera/exportar', 'ExportarController@exportarRdaCarreraInstitucionalesExcel');
  Route::get('/reportes/reportes-carrera/pdf/exportar', 'ExportarController@exportarRdaCarreraInstitucionales');
  Route::get('/reportes/rda-observaciones','ReporteController@observacionesConsulta');
  Route::get('/reportes/rda-observaciones/ver','ReporteController@observaciones');
  Route::get('/reportes/rda-observaciones/exportar','ExportarController@observacionesExcel');
  Route::get('/reportes/rda-observaciones/{id}/detalles/{carrera}/{periodo}', 'ReporteController@observacionesDetalle');
  Route::get('/reportes/rda-observaciones/{id}/detalles/{carrera}/{periodo}/exportar', 'ExportarController@observacionesDetalleExcel');
  Route::get('/reportes/rda-observaciones-mapeo-general', 'ReporteController@observacionesMapeoConsulta');
  Route::get('/reportes/rda-observaciones-mapeo-general/ver','ReporteController@observacionesMapeo');
  Route::get('/reportes/rda-observaciones-mapeo-general/exportar','ExportarController@observacionesMapeoExcel');
  Route::get('/reportes/rda-perfil-materias','ReporteController@rdaPerfilMateriasConsultar');
  Route::get('/reportes/rda-perfil-materias/ver','ReporteController@rdaPerfilMaterias');
  Route::get('/reportes/rda-perfil-materias/exportar', 'ExportarController@rdaPerfilMateriasExcel');
  Route::get('/reportes/rda-perfil-materias/pdf/exportar', 'ExportarController@rdaPerfilMaterias');
  Route::get('/reportes/rda-perfil-materias-consolidado', 'ReporteController@RDAPerfilMateriaConsolidadoConsultar');
  Route::get('/reportes/rda-perfil-materias-consolidado/ver', 'ReporteController@RDAPerfilMateriaConsolidado');
  Route::get('/reportes/rda-perfil-materias-consolidado/pdf/exportar', 'ExportarController@RDAPerfilMateriaConsolidado');
  Route::get('/reportes/rda-perfil-materias-consolidado/exportar', 'ExportarController@RDAPerfilMateriaConsolidadoExcel');
  /* ---------------------------------------------------------
   *  API MATERIAS
   * --------------------------------------------------------*/
  Route::get('silabos/carreras', 'SilaboController@carreras');

  Route::get('silabos/carrera/{id}', 'SilaboController@listDetails');

  /* ----------------------------------------------------------
   *  Perfil Usuarios
   * ----------------------------------------------------------*/
   Route::post('/perfil/{id}/change-password','Auth\PasswordController@changePassword');
   Route::get('perfil/{id}','UsuarioController@getById');


  Route::get('usuarios','UsuarioController@consultar');
   Route::get('usuarios/mostrar','UsuarioController@show');

  /* ---------------------------------------------------------
   *  REPORTES
   * --------------------------------------------------------*/
   Route::group(['middleware' => 'auth','prefix' => 'reporte'], function () {
       Route::get('mallaCurricular', 'ReporteController@malla');

  		 // Rda-Carreras
  		 Route::get('rda-carreras', 'ReporteController@rdaCarreras');
  		 Route::get('rda-carreras/mostrar', 'ReporteController@rdaCarrerasMostrar');
   });


   //Route::get('/param/periodo', 'PeriodoController@index');
   //Route::post('/param/periodo', 'PeriodoController@switch');

  Route::get('silabos/materia/{id}/pdf', function($id){

  	$data = array(
  		'id' => $id
  	);

  	$pdf = PDF::loadView('pdf.silabo.materia', ['data'=> $data]);
  	return $pdf->stream('silabo.pdf');
  });

  Route::get('excel',function(){

  	return Excel::create('New file', function($excel) {

      $excel->sheet('New sheet', function($sheet) {

          $sheet->loadView('excel.test');

      });

  	})->export('xls');
  });
});
/* ---------------------------------------------------------
 *  SISTEMA PARAMETROS
 * --------------------------------------------------------*/
   Auth::routes();
// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
//   'param/periodo' => 'PeriodoController'
// ]);
Route::group(['prefix'=>'param/periodo'], function(){
  Route::get('/','PeriodoController@getIndex');
  Route::post('/','PeriodoController@postIndex');
  Route::get('/add','PeriodoController@getAdd');
  Route::post('/add','PeriodoController@postAdd');
});
