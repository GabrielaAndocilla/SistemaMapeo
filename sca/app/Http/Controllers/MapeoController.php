<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Udla\Model\MapeoObservacion;
use Udla\Model\RdaCarrera;
use Udla\Model\Mapeo;
use Udla\Model\Periodo;
use Udla\Model\RdaUniversidad;
use Auth;
use Input;
use Udla\Model\Career;
use Excel;
use Exception;
use ActualPeriodo;

class MapeoController extends Controller {

	private $datos;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		//
		$materias = DB::select("Select distinct pm.id,m.codigo_materia, m.nombre_materia, pm.semestre, m.organizacion_curricular, pm.area_formacion, a.descripcion as area, pm.creditos, pm.tipo_asignatura FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and a.id = pm.area_formacion and c.codigo = ? order by pm.semestre",[$id]);
		$semestres = DB::select("Select pm.semestre FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$id]);

		foreach($materias as $materia)
		{
			$rdaCarrera = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE rc.carrera = ? AND rc.periodo = ?",[$id,ActualPeriodo::getActualPeriodo()->codigo]);

			foreach($rdaCarrera as $rdaC){
				$rdaMateria = DB::select("SELECT distinct rda.id, rda.rda, rda.mde, rda.observaciones, rda.nivel FROM rda_periodo_materia as rda WHERE rda_carrera_id = ? and periodo_materia = ?",[$rdaC->id,$materia->id]);
				$rdaC->rdaMateria = $rdaMateria;
			}
			$materia->rdaCarrera = $rdaCarrera;

			$materia->prerequisitos =  DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=1',[$materia->id]);
			$materia->correquisitos = DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=2',[$materia->id]);
		}

		$rdaCarreras = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE rc.carrera = ? AND rc.periodo = ?",[$id,ActualPeriodo::getActualPeriodo()->codigo]);
		$periodoActual = ActualPeriodo::getActualPeriodo()->codigo;
		$observaciones = Mapeo::where('carrera',$id)
		->where('periodo',$periodoActual)->get();

		try
		{
			$observacion = MapeoObservacion::observacion($id,$periodoActual)->observacion;
			$responsables = MapeoObservacion::observacion($id,$periodoActual)->responsables;
		}catch(Exception $ex) {
			$observacion = "";
			$responsables = "";
		}

			$datos = array(
			"carrera" => $id,
			"rdaCarreras" => $rdaCarreras,
			"rdaUniversidad" => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]),
			"materias" => $materias,
			"semestres" => $semestres,
			"observaciones" => $observaciones,
			"responsables" => $responsables,
			"observacion" => $observacion
		);

		//var_dump($materias[20]->prerequisitos[0]->materia_codigo);
		//exit();
		return view('pages.mapeo.index')->with('datos',$datos);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function withPeriodo($id,$periodo)
	{
		//
		$materias = DB::select("Select distinct pm.id,m.codigo_materia, m.nombre_materia, pm.semestre, m.organizacion_curricular, pm.area_formacion, a.descripcion as area, pm.creditos, pm.tipo_asignatura FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.codigo = ? and pm.c_materia = cm.id and a.id = pm.area_formacion and c.codigo = ? order by pm.semestre",[$periodo,$id]);
		$semestres = DB::select("Select pm.semestre FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.codigo = ? and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$periodo,$id]);

		foreach($materias as $materia)
		{
			$rdaCarrera = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE carrera = ? AND periodo = ?",[$id,$periodo]);

			foreach($rdaCarrera as $rdaC){
				$rdaMateria = DB::select("SELECT distinct rda.id, rda.rda, rda.mde, rda.observaciones, rda.nivel FROM rda_periodo_materia as rda WHERE rda_carrera_id = ? and periodo_materia = ?",[$rdaC->id,$materia->id]);
				$rdaC->rdaMateria = $rdaMateria;
			}
			$materia->rdaCarrera = $rdaCarrera;

			$materia->prerequisitos =  DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=1',[$materia->id]);
			$materia->correquisitos = DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=2',[$materia->id]);
		}

		$rdaCarreras = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE rc.carrera = ? AND rc.periodo = ?",[$id,$periodo]);
		$periodoActual = Periodo::where('estado', 1)->get()[0]->codigo;

		$observaciones = Mapeo::where('carrera',$id)
		->where('periodo',$periodo)->get();


		try
		{
			$observacion = MapeoObservacion::observacion($id,$periodo)->observacion;
					$responsables = MapeoObservacion::observacion($id,$periodoActual)->responsables;
		}catch(Exception $ex) {
			$observacion = "";
			$responsables="";
		}


			$datos = array(
			"carrera" => $id,
			"rdaCarreras" => $rdaCarreras,
			"rdaUniversidad" => DB::select('SELECT rc.id, ru.rda_universidad_abrev FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]),
			"materias" => $materias,
			"periodo" => $periodo,
			"semestres" => $semestres,
			"observaciones" => $observaciones,
			"responsables" => $responsables,
			"observacion" => $observacion,
			"periodoActual" => $periodoActual
		);

		//var_dump($materias[20]->prerequisitos[0]->materia_codigo);
		//exit();
		return view('pages.mapeo.index')->with('datos',$datos);
	}

	/**
* Almacenar la observación del Mapeo.
*
* @param  int  $id
* @return Response
*/
 public function addObservacion(Request $request,$id)
 {
	 $this->validate($request, [
			'observacion' => 'required',
	]);
	$periodoActual = ActualPeriodo::getActualPeriodo()->codigo;
	try
	{
		$observacion = MapeoObservacion::observacion($id,$periodoActual);
		$observacion->observacion = $request->input('observacion');
		$observacion->responsables =  $request->input('responsables');
		$observacion->user_updated = Auth::user()->id;
	}catch(Exception $ex) {
		$observacion = new MapeoObservacion();
		$observacion->observacion = $request->input('observacion');
		$observacion->responsables =  $request->input('responsables');
		$observacion->carrera = $id;
		$observacion->periodo = $periodoActual;
		$observacion->user_created = Auth::user()->id;
	}
	$observacion->save();

	$url = "/mapeo/".$id."/".$periodoActual;
	return redirect($url)->with('mensaje', 'Ingreso de observacion exitoso!');


 }


	public function newMapeo($id){
		//
		$materias = DB::select("Select distinct pm.id,m.codigo_materia, m.nombre_materia, m.organizacion_curricular, m.area_formacion, a.descripcion as area, pm.creditos, pm.prerequisito, pm.tipo_asignatura FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$id]);

		foreach($materias as $materia)
		{
			$rdaCarrera = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE carrera = ?",[$id]);

			foreach($rdaCarrera as $rdaC){
				$rdaMateria = DB::select("SELECT distinct rda.id, rda.rda, rda.mde, rda.observaciones, rda.nivel FROM rda_periodo_materia as rda WHERE rda_carrera_id = ? and periodo_materia = ?",[$rdaC->id,$materia->id]);
				$rdaC->rdaMateria = $rdaMateria;
			}
			$materia->rdaCarrera = $rdaCarrera;

			$materia->prerequisitos =  DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=1',[$materia->id]);
			$materia->correquisitos = DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=2',[$materia->id]);
		}

		$rdaCarreras = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE carrera = ?",[$id]);
		$periodoActual = Periodo::where('estado', 1)->get()[0]->codigo;
		$observaciones = Mapeo::where('carrera',$id)
		->where('periodo',$periodoActual)->get();

			$datos = array(
			"rdaCarreras" => $rdaCarreras,
			"rdaUniversidad" => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]),
			"materias" => $materias,
			"observaciones" => $observaciones
		);
		return view('pages.mapeo.newMapeo')->with('datos',$datos);
	}

	public function consultar(){
		$carrers = Career::all();
		$datos =  [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('pages.mapeo.consultar')->with('datos',$datos);
	}

	public function routeCarrera(){
		if(Input::get('reporte') == 1){
				$url = "mapeo/".Input::get('carrera')."/".Input::get('periodo');
		}else if(Input::get('reporte') == 2){
				$url = "mapeocarrera/".Input::get('carrera')."/".Input::get('periodo');
		}

		return redirect($url);
	}

	public function exportar($id,$periodo){

		$materias = DB::select("Select distinct pm.id,m.codigo_materia, m.nombre_materia, pm.semestre, m.organizacion_curricular, pm.area_formacion, a.descripcion as area, pm.creditos, pm.tipo_asignatura FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.codigo = ? and pm.c_materia = cm.id and a.id = pm.area_formacion and c.codigo = ? order by pm.semestre",[$periodo,$id]);
		$semestres = DB::select("Select pm.semestre FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.codigo = ? and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$periodo,$id]);

		foreach($materias as $materia)
		{
			$rdaCarrera = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE carrera = ? AND periodo = ?",[$id,$periodo]);

			foreach($rdaCarrera as $rdaC){
				$rdaMateria = DB::select("SELECT distinct rda.id, rda.rda, rda.mde, rda.observaciones, rda.nivel FROM rda_periodo_materia as rda WHERE rda_carrera_id = ? and periodo_materia = ?",[$rdaC->id,$materia->id]);
				$rdaC->rdaMateria = $rdaMateria;
			}
			$materia->rdaCarrera = $rdaCarrera;

			$materia->prerequisitos =  DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=1',[$materia->id]);
			$materia->correquisitos = DB::select('Select * From pm_co_requisito WHERE pm_materia_id=? and type=2',[$materia->id]);
		}

		$rdaCarreras = DB::select("SELECT rc.id, rc.rda_carrera as nombre FROM  rda_carrera as rc WHERE rc.carrera = ? AND rc.periodo = ?",[$id,$periodo]);
		$periodoActual = Periodo::where('estado', 1)->get()[0]->codigo;
		$observaciones = Mapeo::where('carrera',$id)
		->where('periodo',$periodoActual)->get();

		try
		{
			$observacion = MapeoObservacion::observacion($id,$periodoActual)->observacion;
		}catch(Exception $ex) {
			$observacion = "";
		}

			$datos = array(
			"carrera" => $id,
			"rdaCarreras" => $rdaCarreras,
			"rdaUniversidad" => DB::select('SELECT rc.id, ru.rda_universidad_abrev FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]),
			"materias" => $materias,
			"semestres" => $semestres,
			"observaciones" => $observaciones,
			"observacion" => $observacion
		);
		$this->datos = $datos;
		return 	Excel::create('Mapeo', function($excel) {

	    $excel->sheet('Mapeo de la carrera', function($sheet) {

	        $sheet->loadView('excel.mapeo')->with('datos',$this->datos);

	    });
			$lastrow= $excel->getActiveSheet()->getHighestRow();
			$excel->getActiveSheet()->getStyle('A1:DK'.$lastrow)->getAlignment()->setWrapText(true);

		})->export('xls');
	}

	public function mapeoCarrera($id, $periodo)
	{
		$rdaUniversidad = RdaUniversidad::getRdasPorPeriodo($periodo);
		$rdaCarreras = DB::select('SELECT * FROM rda_carrera as rc INNER JOIN periodo as p WHERE rc.periodo = ? and p.estado = 1 and carrera = ?',[$periodo,$id]);
		$rdaUniversidadxCarrera = DB::select('SELECT rc.id, ru.id as idUniversidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]);
		$datos = array(
		  	"carrera" => $id,
		  	"rdaCarreras" => $rdaCarreras,
			"rdaUniversidadxCarrera" => $rdaUniversidadxCarrera,
			"rdaUniversidad" => $rdaUniversidad
		);

		return view('pages.mapeo.muniversidad')->with('datos',$datos);
	}

	public function mapeoCarreraExcel($id)
	{
		//Select rc.rda_universidad FROM rda_carrera as rc INNER JOIN rda_universidad as ru WHERE rc.rda_universidad = ru.id
		$rdaUniversidad = RdaUniversidad::all();
		$rdaCarreras = DB::select('SELECT * FROM rda_carrera as rc INNER JOIN periodo as p WHERE rc.periodo = p.codigo and p.estado = 1 and carrera = ?',[$id]);

		$datos = array(
		  	"carrera" => $id,
		  	"rdaCarreras" => $rdaCarreras,
			"rdaUniversidadxCarrera" => DB::select('Select rc.id, ru.id as idUniversidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[$id]),
			"rdaUniversidad" => $rdaUniversidad
		);
		$this->datos = $datos;
		// return view('excel.mapeo')->with('datos',$this->datos);
		return 	Excel::create('Mapeo RdA de carrera versus RdA Institucional', function($excel) {

	    $excel->sheet('Mapeo de la carrera', function($sheet) {

	        $sheet->loadView('excel.mapeocarrera')->with('datos',$this->datos);

	    });
			$lastrow= $excel->getActiveSheet()->getHighestRow();
			$excel->getActiveSheet()->getStyle('A1:L'.$lastrow)->getAlignment()->setWrapText(true);

		})->export('xls');
	}

	public function addObservaciones(Request $request){
		$observaciones = $request->datos[0];
		$responsables = $request->res[0];

		$rdaCarreras = RdaCarrera::where('carrera',$request->carrera)->where('periodo',$request->periodo)->get();
		$periodoActual = Periodo::where('estado', 1)->get()[0]->codigo;
		for($i=0;$i<count($rdaCarreras);$i++){
			$mapeo = Mapeo::where('carrera', $request->carrera)
			->where('periodo',$request->periodo)
			->where('rda_carrera',$rdaCarreras[$i]->id)
			->first();

			if($mapeo != null){
				$mapeo->observaciones = $observaciones[$i];
				$mapeo->responsables = $responsables[$i];
				$mapeo->user_updated = Auth::user()->id;
				$mapeo->update();
			}else{
				$mapeo = new Mapeo();
				$mapeo->carrera = $request->carrera;
				$mapeo->observaciones = $observaciones[$i];
				$mapeo->responsables = $responsables[$i];
				$mapeo->rda_carrera = $rdaCarreras[$i]->id;
				$mapeo->periodo = $periodoActual;
				$mapeo->user_created = Auth::user()->id;
				$mapeo->user_updated = Auth::user()->id;
				$mapeo->save();
			}


		}

		return response()->json([
			"msg" => "Success"
		],200);
	}

}
//SELECT DISTINCT COUNT(*) FROM periodo_materia as pm INNER JOIN carrera as c, carrera_materia as cm WHERE pm.semestre=2 and cm.cod_carrera=1 and cm.id=pm.c_materia and cm.cod_carrera=c.codigo
