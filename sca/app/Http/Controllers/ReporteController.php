<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Udla\Model\RdaUniversidad;
use Udla\Model\RdaCarrera;
use Udla\Model\Signature;
use Udla\Model\User;
use Udla\Model\Career;
use Udla\Model\LogroCarrera;
use Udla\Model\Periodo;
use Udla\Model\PeriodoMateria;
use ActualPeriodo;
use Udla\Model\MapeoObservacion;
use DB;
use Input;
use Excel;
use Illuminate\Http\Request;
use Exception;

class ReporteController extends Controller {

	private $export_data;

	/**
	 * Reporte
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show()
	{
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('pages.Reportes.show')->with('datos',$datos);
	}

	public function mostrar()
	{
		$codigo_periodo = Input::get('periodo');
		$id_carrera = Input::get('carrera');
		$rdaUniversidad = RdaUniversidad::getRdasPorPeriodo2($codigo_periodo);
		$datos = array(
			'rdaUniversidad' => $rdaUniversidad,
			'carrera' => $id_carrera,
			'periodo' => $codigo_periodo
		);
		return view('pages.Reportes.mostrar')->with('datos',$datos);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 *
	 * @return Response
	 */
	public function edit()
	{
		$reportes = RdaUniversidad::all();
		return view('pages.Reportes.editado')->with('reportes',$reportes);
	}

	/**
	 * Update RDA Universidad
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$reporte=new RdaUniversidad();
				$materia->codigo_materia=Input::get('siglas');
				$materia->nombre_materia=Input::get('materia');
				$materia->nivel_formacion=Input::get('nivelformacion');
				$materia->area_formacion=Input::get('areaformacion');
				$materia->type=Input::get('tipo');
				$materia->user_created=Auth::user()->id;
				$materia->save();
		$url = "/reportes/gestion-reportes/editar";
		if($rdaUniversidad->save()){
			return redirect($url)->with('mensaje', 'Actualización exitosa');
		}else{
			return redirect($url)->with('warning', 'No se ha podido actualizar');
		}
	}

	public function apiSobrecargaRdaCarrera($id){
		$consulta = DB::select('Select rc.rda_carrera, ca.cod_materia as materia, COUNT(rpm.id) as numero from carrera as c INNER JOIN carrera_materia as ca, rda_carrera as rc, periodo_materia as pm, rda_periodo_materia as rpm , periodo as p WHERE p.estado = 1 and pm.periodo = p.codigo and c.codigo = ca.cod_carrera and pm.c_materia = ca.id and rc.carrera = c.codigo and rc.id = rpm.rda_carrera_id and rpm.rda_carrera_id = rc.id and rpm.periodo_materia = pm.id and c.codigo = ? Group by rc.rda_carrera,ca.cod_materia',[$id]);
		//$query = array(array());
		for($i=0;$i<count($consulta);$i++){
			$query[$i] = array($consulta[$i]->rda_carrera.'|'.$consulta[$i]->materia.';'.$consulta[$i]->numero);
		}
		//return response()->json($query);

		// return \Response::make($query, '200')->header('Content-Type', 'plain/txt');
		 $filename = 'visit-sequences';
		 $this->export_data = $query;
		 return Excel::create($filename, function($excel) {

		     // Call writer methods here
				  $excel->sheet('Sheetname', function($sheet) {
				 $sheet->fromArray($this->export_data);
			 });

		 })->download('csv');

		//return \Response::make($query, 200, $headers);
	}

	public function rdaCarreras(){
		$carrers = Career::all();
		$datos = [
			'carreras' =>$carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.grafico.rdaCarreras.consulta')->with('datos',$datos);
	}

	public function rdaCarrerasMostrar(){
		$carrera = Input::get('carrera');
		$datos = [
			'carrera' =>$carrera,
			'periodo' => Input::get('periodo')
		];
		return view('reportes.grafico.rdaCarreras.index')->with('datos',$datos);
	}

	public function generalConLogros(){
		$carrers = Career::all();
		$datos = [
			'carreras' =>$carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.reporteGeneralConLogros.consultar')->with('datos',$datos);
	}

	public function generalConLogrosShow(){
		$codigo_periodo = Input::get('periodo');
		$id_carrera = Input::get('carrera');
		$rdaUniversidad = RdaUniversidad::getRdasPorPeriodo2($codigo_periodo);
		$logros = DB::select('Select ru.id, ru.rda_universidad, ru.logros FROM rda_universidad as ru');
		$rdaCarrera = RdaCarrera::where('carrera', $id_carrera)->where('periodo',$codigo_periodo)->get();
		$rdaUniCarrera = DB::select('select * from  rda_universidad_carrera as ruc INNER JOIN rda_carrera as ra where ra.carrera = ? and ruc.rda_carrera_id = ra.id', [$id_carrera]);
		$logrosCarrera = DB::select('Select rucl.logro_carrera, rucl.rda_uni_id FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru WHERE rucl.rda_uni_id=ru.id and carrera_codigo = ?',[$id_carrera]);

		$datos = array(
			'rdaUniversidad' => $rdaUniversidad,
			'rdaCarrera' => $rdaCarrera,
			'rdaUniCarrera' => $rdaUniCarrera,
			'logros' => $logros,
			'logrosCarrera' => $logrosCarrera,
			'carrera' => $id_carrera,
			'periodo' => $codigo_periodo
		);
		return view('reportes.reporteGeneralConLogros.index')->with('datos',$datos);
	}


	public function observacionesConsulta(){
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.rdaObservaciones.consultar')->with('datos',$datos);
	}

	public function observacionesDetalle($id,$carrera,$periodo){
		$observaciones = DB::select("Select rpm.id, rpm.rda, rpm.mde, rpm.nivel,rpm.observaciones,rpm.responsables, pm.observacion FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm, carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and rpm.periodo_materia = pm.id and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and rpm.observaciones != 'Sin Observaciones' and rpm.observaciones != ' ' and m.codigo_materia = ?", [$periodo,$carrera,$id]);
		$observacionesGenerales = DB::select("Select pm.observacion FROM periodo_materia as pm INNER JOIN carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and pm.observacion != ' ' and m.codigo_materia = ?", [$periodo,$carrera,$id]);
		$materia = DB::select("Select m.nombre_materia FROM periodo_materia as pm INNER JOIN carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and m.codigo_materia = ? ", [$periodo,$carrera,$id])[0];
		$periodoMateria = PeriodoMateria::where('periodo',$periodo)
		->whereHas('careerSignature', function($query) use($carrera,$id){
			$query->where('cod_carrera',$carrera)->where('cod_materia',$id);
		})->first();
		$datos = [
			'carrera' => $carrera,
			'observaciones' => $observaciones,
			'observacionesGenerales' => $observacionesGenerales,
			'materia' => $materia,
			'periodo' => $periodo,
			'periodoMateria' => $periodoMateria,
			'id' => $id
		];
		return view('reportes.rdaObservaciones.detalle')->with('datos',$datos);
	}

	public function observaciones(){
		$observaciones = DB::select("Select DISTINCT m.codigo_materia as materia, m.nombre_materia as nombre,pm.observacion, pm.responsables FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm, carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and rpm.periodo_materia = pm.id and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and (rpm.observaciones != 'Sin Observaciones' or pm.observacion != 'NULL') and (rpm.observaciones != ' ' or pm.observacion != ' ')", [Input::get('periodo'),Input::get('carrera')]);
		$datos = [
			'carrera' => Input::get('carrera'),
			'observaciones' => $observaciones,
			'periodo' => Input::get('periodo')
		];
		return view('reportes.rdaObservaciones.index')->with('datos',$datos);
	}

	public function observacionesMapeoConsulta(){
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.rdaObservacionesMapeo.consulta')->with('datos',$datos);
	}

	public function observacionesMapeo(){
		$carrera = Input::get('carrera');
		$periodo = Input::get('periodo');
		$observaciones = DB::select("SELECT rc.id, rc.rda_carrera as rda, ma.observaciones as observacion, ma.responsables FROM  rda_carrera as rc INNER JOIN mapeo as ma WHERE ma.carrera = ? and rc.id=ma.rda_carrera and ma.periodo=?", [$carrera, $periodo]);
		try
		{
			$observacion = MapeoObservacion::observacion($carrera, $periodo)->observacion;
			$responsables = MapeoObservacion::observacion($carrera, $periodo)->responsables;
		}catch(Exception $ex) {
			$observacion = "";
			$responsables= "";
		}
		$datos = [
			'carrera' => $carrera,
			'observaciones' => $observaciones,
			'responsables' => $responsables,
			'observacion' => $observacion,
			'periodo' => $periodo
		];
		return view('reportes.rdaObservacionesMapeo.indice')->with('datos',$datos);
	}

	public function rdaPerfilMaterias(){
		$rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',Input::get('periodo'))->get();
		$materias= DB::select('Select DISTINCT m.codigo_materia, m.nombre_materia, rc.id, rpm.rda, rpm.nivel FROM materia as m
		INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, rda_carrera as rc, rda_periodo_materia as rpm WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.codigo = ? and pm.c_materia = cm.id and c.codigo = ? and rc.carrera = c.codigo and rpm.periodo_materia = pm.id and rpm.rda_carrera_id = rc.id order by rpm.nivel asc', [Input::get('periodo'),Input::get('carrera')]);
		$datos = [//array(
			'rdaCarrera' => $rdaCarrera,
			'rdaUniversidad' => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ? and rc.periodo = ?',[Input::get('carrera'), Input::get('periodo')]),
			'materias' => $materias,
			'carrera' => Input::get('carrera'),
			'periodo' => Input::get('periodo')
		];//);
		return view('reportes.rdaPerfilMateria.reporte')->with('datos',$datos);
	}

	public function rdaPerfilMateriasConsultar(){
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.rdaPerfilMateria.consultar')->with('datos',$datos);
	}

	public function RDAPerfilMateriaConsolidadoConsultar()
	{
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('reportes.RDA-materia-consolidado.consultar')->with('datos',$datos);
	}

	public function RDAPerfilMateriaConsolidado()
	{
		$carrera = Input::get('carrera');
		$periodo = Input::get('periodo');
		$rdaCarrera = RdaCarrera::where('carrera',$carrera)->where('periodo',$periodo)->get();
 		$niveles=DB::select('call spReporteConsolidado(?,?)',[$carrera,$periodo]);
		$rdaUniversidad = DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ? and rc.periodo = ?',[$carrera, $periodo]);
		$datos = [//array(
			'rdaCarrera' => $rdaCarrera,
			'rdaUniversidad' => $rdaUniversidad,
			'niveles' => $niveles,
			'carrera' => $carrera,
			'periodo' => $periodo
		];
		return view('reportes.RDA-materia-consolidado.index')->with('datos',$datos);
	}
}