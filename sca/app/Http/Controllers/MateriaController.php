<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Udla\Model\RdaPeriodo;
use Udla\Model\RdaCarrera;
use Udla\Model\Career;
use Udla\Model\PeriodoMateria;
use Udla\Model\Signature;
use Udla\Model\User;
use Input;
use Auth;
use DB;
use Validator;
use Udla\Model\Area;
use File;

class MateriaController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		return view('pages.materia.index')->with('carrera',$id);
	}

	public function apiMateria($id){
		$idUser = Auth::user()->id;
		if(Auth::user()->type == 2){
			$data = DB::select('Select m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable, pm.semestre,cm.cod_carrera as carrera, a.descripcion as area from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p, area as a WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and m.categoria <> 1 and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and a.id = pm.area_formacion and pm.responsable=?',[$id, $idUser]);
		}else{
			$data = DB::select('Select m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable, pm.semestre,cm.cod_carrera as carrera, a.descripcion as area from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p, area as a WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and m.categoria <> 1 and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and a.id = pm.area_formacion',[$id]);
		}
		return response()->json($data,200);
	}

	public function apiMateriaGeneral($id){
		$data = DB::select('Select m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable, pm.semestre,cm.cod_carrera as carrera, a.descripcion as area from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p, area as a WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and m.categoria = 1 and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and a.id = pm.area_formacion',[$id]);
		return response()->json($data,200);
	}

	public function apiMateriaByArea($carrera, $area){
		$tipoUser = Auth::user()->id;
		if(Auth::user()->type == 2){
			$data = DB::select('Select m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable, pm.semestre,cm.cod_carrera as carrera, a.descripcion as area from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p, area as a WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and m.categoria <> 1 and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and a.id = pm.area_formacion and pm.area_formacion = ? and pm.responsable=?',[$carrera,$area, $idUser]);
		}else{
			$data = DB::select('Select m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable, pm.semestre,cm.cod_carrera as carrera, a.descripcion as area from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p, area as a WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and m.categoria <> 1 and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and a.id = pm.area_formacion and pm.area_formacion = ?',[$carrera,$area]);
		}
		return response()->json($data,200);
	}

	public function consultar(){
		$carreras = Career::all();
		return view('pages.materia.consulta')->with('carreras',$carreras);
	}

	public function listEspecializacion(){

	}

	/*public function generales(){

		$data = DB::select('SELECT m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, c.nombre as carrera, pm.responsable, pm.observacion FROM materia as m INNER JOIN periodo_materia as pm, periodo as p, carrera_materia as cm, carrera as c WHERE m.categoria = 0 and pm.c_materia = cm.id and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and cm.cod_carrera = c.codigo');
		return view('pages.materia.index')->with('datos',$data);

	}*/

	public function generalesConsulta(){
		$carreras = Career::all();
		return view('pages.materia.consulta-generales')->with('carreras',$carreras);
	}

	public function routeGenerales(){
		$url = "/materias/generales/" . Input::get('carrera');
		return redirect($url);
	}

	public function mostrarGenerales($id){
		return view('pages.materia.index-generales')->with('carrera',$id);
	}

	public function siglas($id){
		$siglas = DB::select('SELECT m.codigo_materia FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm WHERE p.estado = 1 and pm.periodo = p.codigo and cm.cod_carrera = ? and cm.id = pm.c_materia and cm.cod_materia = m.codigo_materia ORDER BY m.codigo_materia ASC',[$id]);
		return response()->json($siglas);
	}

	public function areas($id){
		$areas = DB::table('area')->where('carrera_codigo',$id)->get();
		return response()->json($areas);
	}

	public function listar(){
		if(Input::get('area') != null){
			$materias = DB::select('Select pm.id, m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1 and pm.area_formacion = ?',[Input::get('carrera'), Input::get('area')]);
		}else{
				$materias = DB::select('Select pm.id, m.codigo_materia as codigo,m.nombre_materia as nombre, pm.silabo as pdf, pm.responsable from materia as m Inner Join carrera as c, carrera_materia as cm, periodo_materia as pm, periodo as p WHERE c.codigo = ? and cm.cod_carrera = c.codigo and m.codigo_materia = cm.cod_materia and pm.c_materia = cm.id and pm.periodo = p.codigo and p.estado = 1',[Input::get('carrera')]);
		}
		$data = array(
			'materias' => $materias,
			'carrera' => Input::get('carrera')
		);
		return view('pages.materia.lista')->with('datos',$data);
	}

	public function eliminarSilabo($id, $carrera){

		$ido = DB::select("SELECT pm.id FROM periodo_materia as pm Inner Join carrera_materia as cm, periodo as p WHERE cm.cod_carrera = ? and cm.cod_materia = ? and p.estado = 1 and pm.periodo = p.codigo and pm.c_materia=cm.id",[$carrera,$id])[0];
		$update = DB::table('periodo_materia')
				->where('id',$ido->id)
				->update(['silabo' => '','user_updated' => Auth::user()->id]);
		$url = "materia/$id/$carrera/edit";
		if($update){
				return redirect($url)->with('warning', 'Sílabo eliminado');
		}else{
				return redirect($url)->with('error', 'No se ha podido eliminar sílabo');
		}


	}

	public function observacion($id, $carrera){
				//$ido = DB::select("SELECT pm.id FROM periodo_materia as pm Inner Join carrera_materia as cm, periodo as p WHERE cm.cod_carrera = ? and cm.cod_materia = ? and p.estado = 1 and pm.periodo = p.codigo and cm.id = pm.c_materia",[$carrera,$id])[0];
				$ido = PeriodoMateria::whereHas('careerSignature', function($query) use ($id,$carrera){
					$query->where('cod_materia',$id)->where('cod_carrera',$carrera);
				})->whereHas('period', function($query){
					$query->where('estado',1);
				})->first();

				$update = DB::table('periodo_materia')
						->where('id',$ido->id)
						->update([
							'responsables' => Input::get('responsables'),
							'observacion' => Input::get('observacion'),'user_updated' => Auth::user()->id
						]);
				$url = "materia/$id/$carrera/edit";

				if($update){
						return redirect($url)->with('success', 'Se ha añadido la observacion');
				}else{
						return redirect($url)->with('error', 'No se ha podido añadir la observacion');
				}
	}

	public function editar($id){

		$materia = DB::select('Select pm.id,c.codigo as carrera_id,c.nombre as carrera, pm.area_formacion, m.organizacion_curricular, m.tipo_asignatura, m.campo_formacion, m.categoria as categoria, m.nombre_materia as nombre, m.codigo_materia as sigla, pm.prerequisito, pm.responsable, pm.creditos, pm.semestre, pm.observacion FROM materia as m INNER JOIN periodo_materia as pm, periodo as p, carrera_materia as cm, carrera as c WHERE pm.id = ? and pm.c_materia = cm.id and m.codigo_materia = cm.cod_materia and p.estado = 1 and p.codigo = pm.periodo and c.codigo = cm.cod_carrera',[$id])[0];
		$areas = Area::where('carrera_codigo',$materia->carrera_id)->get();
		$profesores =User::where('type','=','2')->orWhere('type','=','3')->orWhere('type','=','99')->where('career',$materia->carrera_id)->get();
		$siglas = DB::select('SELECT m.codigo_materia FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm WHERE p.estado = 1 and pm.periodo = p.codigo and cm.cod_carrera = ? and cm.id = pm.c_materia and cm.cod_materia = m.codigo_materia ORDER BY m.codigo_materia ASC',[$materia->carrera_id]);
		$data = array(
			'materia' => $materia,
			 'profesores' => $profesores,
			 'siglas' => $siglas,
			 'areas' => $areas,
			 'prerequisitos' => DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=1',[$id]) ,
			 'correquisitos' => DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=2',[$id])
		 );
		return view ('pages.materia.editar')->with('datos', $data);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id,$carrera)
	{
		//
		//$signature = DB::select('Select m.codigo_materia, m.nombre_materia, m.organizacion_curricular, m.area_formacion, m.categoria, p.codigo, p.year, p.period,p.estado, pm.id, pm.periodo, pm.c_materia, pm.responsable, pm.silabo, cm.id as cmID, cm.cod_carrera as cmCarrera, pm.observacion FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm  WHERE m.codigo_materia = ? and pm.c_materia = cm.id and cm.cod_materia = m.codigo_materia and cm.cod_carrera = ? and p.estado = 1 and pm.periodo = p.codigo',[$id,$carrera]);
		$signature = PeriodoMateria::whereHas('careerSignature', function($query) use ($id,$carrera){
			$query->where('cod_materia',$id)->where('cod_carrera',$carrera);
		})->whereHas('period', function($query){
			$query->where('estado',1);
		})->first();

		$rda = RdaPeriodo::where('periodo_materia', $signature->id)->get();
		$rdaCarrera = DB::select('SELECT rda.id, rda.rda_carrera, rda.carrera, rda.periodo FROM rda_carrera as rda INNER JOIN materia as m, carrera_materia as cm, periodo as p WHERE m.codigo_materia = ? and cm.cod_materia = m.codigo_materia and cm.cod_carrera = rda.carrera and p.estado = 1 and p.codigo = rda.periodo and cm.cod_carrera = ?',[$id,$carrera]);
		$data = array(
    'materia'  => $signature,
    'rda'   => $rda,
		'rdaCarrera' => $rdaCarrera
		);
		return view('pages.materia.edit')->with('data',$data);
	}

	public function destroy($id)
	{
			$p_materia = PeriodoMateria::where('id',$id)->get()[0];
			$c_materia = $p_materia->c_materia;
			if($p_materia->delete())
			{
				$materia = DB::select('SELECT * FROM carrera_materia WHERE id=?',[$c_materia])[0];
				$m = Signature::where('codigo_materia','=',$materia->cod_materia)->get()[0];
				DB::select('DELETE FROM carrera_materia WHERE id=?', [$c_materia]);

				$url = "/gestionar/ingreso-materias/listar?carrera=".$materia->cod_carrera;
				$mensaje = "Se ha elimiado $m->nombre_materia!";
				return redirect($url)->with('warning', $mensaje);
			}else{
				$materia = DB::select('SELECT * FROM carrera_materia WHERE id=?',[$c_materia])[0];
				$m = Signature::where('codigo_materia','=',$materia->cod_materia)->get()[0];

				$url = "/gestionar/ingreso-materias/listar?carrera=".$materia->cod_carrera;
				$mensaje = "No se ha eliminado $m->nombre_materia!";
				return redirect($url)->with('error', $mensaje);
			}

	}

	public function uploadPDF($id,$carrera)
	{
		//
		$file = array('file' => Input::file('file'));
		$rules = array('file' => 'required',
			 'file'=>'mimes:pdf'); //mimes:jpeg,bmp,png and for max size max:10000

		$validation = Validator::make($file, $rules);

		if ($validation->fails())
		{
			//return Response::make($validation->errors->first(), 400);
				return response()->make($validation->errors()->first(), 400);

		}else{
			$signature = DB::select('Select m.codigo_materia, m.nombre_materia, m.organizacion_curricular, m.area_formacion, m.categoria, p.codigo, p.year, p.period,p.estado, pm.id, pm.periodo, pm.c_materia, pm.responsable, pm.silabo, cm.id as cmID, cm.cod_carrera as cmID FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm  WHERE m.codigo_materia = ? and pm.c_materia = cm.id and cm.cod_materia = m.codigo_materia and p.estado = 1 and pm.periodo = p.codigo and cm.cod_carrera = ?',[$id,$carrera]);
			$rda = RdaPeriodo::where('periodo_materia', $signature[0]->id)->get();
			$rdaCarrera = DB::select('SELECT  rda.id, rda.rda_carrera, rda.carrera FROM rda_carrera as rda INNER JOIN materia as m, carrera_materia as cm WHERE m.codigo_materia = ? and cm.cod_materia = m.codigo_materia and cm.cod_carrera = rda.carrera',[$id]);
			if($signature[0]->categoria == 0){
					$destinationPath = 'silabospdf/especializacion'; // upload path
				}else{
					$destinationPath = 'silabospdf/generales'; // upload path
				}
				$file = Input::file('file');
				$extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
				//$extension = File::extension($file['name']);
				$fileName = $carrera.'_'.$signature[0]->codigo_materia.'_'.$signature[0]->codigo.'.'.$extension; // renameing image

  		//$upload_success = Input::upload('silabo', $destinationPath, $fileName);

				$upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path

        if( $upload_success ) {
					if($signature[0]->categoria == 0){

							DB::table('periodo_materia')
								->where('id',$signature[0]->id)
								->update(['silabo' => "especializacion/".$fileName]);
					}else{
						DB::table('periodo_materia')
							->where('id',$signature[0]->id)
							->update(['silabo' => "generales/".$fileName]);
					}
        	return response()->json('success', 200);
        } else {
        	return response()->json('error', 400);
        }
			}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$materia = Signature::where('codigo_materia', Input::get('siglas'))->get()[0];

		$materia->nombre_materia=strtoupper(Input::get('materia'));
		$materia->organizacion_curricular=Input::get('organizacioncurricular');
		$materia->tipo_asignatura=Input::get('tipoasignatura');
		$materia->campo_formacion=Input::get('campoformacion');
		$materia->area_formacion=Input::get('areaformacion');
		$materia->categoria=Input::get('categoria');
		$materia->user_modify=Auth::user()->id;

		//$materia->save();
	$ad = 	DB::table('materia')->where('codigo_materia',$materia->codigo_materia)->update(array(
			'nombre_materia' => $materia->nombre_materia,
			'organizacion_curricular' => $materia->organizacion_curricular,
			'tipo_asignatura' => $materia->tipo_asignatura,
			'campo_formacion' => $materia->campo_formacion,
			'area_formacion' => $materia->area_formacion,
			'categoria' => $materia->categoria,
			'user_modify' => $materia->user_modify
		));


		$materia = DB::select('Select c.codigo as carrera FROM materia as m INNER JOIN periodo_materia as pm, periodo as p, carrera_materia as cm, carrera as c WHERE pm.id = ? and pm.c_materia = cm.id and m.codigo_materia = cm.cod_materia and p.estado = 1 and p.codigo = pm.periodo and c.codigo = cm.cod_carrera',[$id])[0];

	//	$periodos=DB::select('SELECT * FROM periodo');
	//	$sigla = $id;
		//for($i=0;$i<count($periodos);$i++)
		//{

			DB::table('periodo_materia')->where('id',$id)->update(array(
				'responsable'  => Input::get('profesor-encargado'),
				'tipo_asignatura' => Input::get('categoria'),
				'creditos' => Input::get('creditos'),
				'area_formacion' => Input::get('areaformacion'),
				'user_updated' => Auth::user()->id,
				'semestre' => Input::get('semestre')
			));
				DB::select("Delete FROM pm_co_requisito WHERE pm_materia_id=? and type=1",[$id]);
			if(Input::get('requisitos') != null && count(Input::get('requisitos')) > 0){
			foreach(Input::get('requisitos') as $requisito){
				DB::table('pm_co_requisito')->insertGetId(array(
					'materia_codigo' => $requisito,
					'pm_materia_id' => $id,
					'type' => 1
				));	
			}
			}

			DB::select("Delete FROM pm_co_requisito WHERE pm_materia_id=? and type=2",[$id]);
			if(Input::get('correquisitos') != null && count(Input::get('correquisitos')) > 0){

				foreach(Input::get('correquisitos') as $correquisito){

				DB::table('pm_co_requisito')->insertGetId(array(
					'materia_codigo' => $correquisito,
					'pm_materia_id' => $id,
					'type' => 2
				));
				}
			}

		//}
		$url = "/gestionar/ingreso-materias/listar?carrera=".$materia->carrera;
		return redirect($url)->with('mensaje', 'Actualización exitosa');

	}

	public function ingreso($id)
	{
		$carrera=Career::where('codigo',$id)->get()[0];
		$areas = Area::where('carrera_codigo',$id)->get();
		$profesores =User::where('type','=','2')->orWhere('type','=','3')->orWhere('type','=','99')->where('career',$carrera->codigo)->get();
		$siglas = DB::select('SELECT m.codigo_materia FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm WHERE p.estado = 1 and pm.periodo = p.codigo and cm.cod_carrera = ? and cm.id = pm.c_materia and cm.cod_materia = m.codigo_materia ORDER BY m.codigo_materia ASC',[$id]);
		$data = array( 'carrera' => $carrera, 'profesores' => $profesores, 'siglas' => $siglas, 'areas' => $areas);
		return view ('pages.materia.ingreso')->with('datos', $data);
	}

	public function ingresar($id)
	{
		$idCarrera = $id;
		$signature = Input::get('siglas');
		$signature = str_replace("-","",$signature);
		$materia = Signature::where('codigo_materia', $signature)->get();
		if(count($materia) > 0){
			$materia = $materia[0];
		} else{
			$materia=new Signature();
			//$signature;
			$materia->codigo_materia=strtoupper($signature);
			$materia->nombre_materia=strtoupper(Input::get('materia'));
			$materia->organizacion_curricular=Input::get('organizacioncurricular');
			$materia->tipo_asignatura=Input::get('tipoasignatura');
			$materia->campo_formacion=Input::get('campoformacion');
			$materia->area_formacion=Input::get('areaformacion');
			$materia->categoria=Input::get('categoria');
			$materia->user_created=Auth::user()->id;
			$materia->save();
		}
		$materias = DB::select('SELECT * FROM carrera_materia WHERE cod_carrera = ? and cod_materia = ?',[$id, $signature]);
		if(count($materias) > 0){
			$carrera=Career::where('codigo',$id)->get()[0];
			$areas = Area::where('carrera_codigo',$id)->get();
			$profesores =User::where('type','=','2')->where('career',$carrera->codigo)->get();
			$siglas = DB::select('SELECT m.codigo_materia FROM materia as m INNER JOIN periodo as p, periodo_materia as pm, carrera_materia as cm WHERE p.estado = 1 and pm.periodo = p.codigo and cm.cod_carrera = ? and cm.id = pm.c_materia and cm.cod_materia = m.codigo_materia ORDER BY m.codigo_materia ASC',[$id]);
			$data = array( 'carrera' => $carrera, 'profesores' => $profesores, 'siglas' => $siglas, 'areas' => $areas, 'duplicated' => true);
			return view ('pages.materia.ingreso')->with('datos', $data);
		}
		$id = DB::table('carrera_materia')->insertGetId(array('cod_carrera' => $id, 'cod_materia' => $signature));
		$periodos=DB::select('SELECT * FROM periodo');
		$sigla = $id;
		for($i=0;$i<count($periodos);$i++)
		{
			$idPM = DB::table('periodo_materia')->insertGetId(array(
				'periodo' => $periodos[$i]->codigo,
				'c_materia' => $sigla,
				'responsable'  => Input::get('profesor-encargado'),
				'tipo_asignatura' => Input::get('categoria'),
				'creditos' => Input::get('creditos'),
				'area_formacion' => Input::get('areaformacion'),	
				'semestre' => Input::get('semestre')
			));
			DB::select("Delete FROM pm_co_requisito WHERE pm_materia_id=? and type=1",[$idPM]);
			if(count(Input::get('requisitos')) > 0)
			{
				foreach(Input::get('requisitos') as $requisito)
				{
					if($requisito != ""){
						DB::table('pm_co_requisito')->insertGetId(array(
							'materia_codigo' => $requisito,
							'pm_materia_id' => $idPM,
							'type' => 1
						));
					}

				}
			}
			DB::select("Delete FROM pm_co_requisito WHERE pm_materia_id=? and type=2",[$idPM]);
			if(Input::get('correquisitos') != null && count(Input::get('correquisitos')) > 0){
				foreach(Input::get('correquisitos') as $correquisito)
				{
					if($correquisito != ""){
						DB::table('pm_co_requisito')->insertGetId(array(
							'materia_codigo' => $correquisito,
							'pm_materia_id' => $idPM,
							'type' => 2
						));
					}
				}
			}
		}
		$url = "/gestionar/ingreso-materias/listar?carrera=".$idCarrera;
		return redirect($url)->with('mensaje', 'Ingreso exitoso');
	}
}
