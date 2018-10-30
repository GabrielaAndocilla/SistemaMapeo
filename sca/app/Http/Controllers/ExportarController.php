<?php

namespace Udla\Http\Controllers;

use Illuminate\Http\Request;
use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;
use Udla\Model\RdaUniversidad;
use Udla\Model\PeriodoMateria;
use Udla\Model\RdaCarrera;
use Udla\Model\Signature;
use Udla\Model\Periodo;
use Udla\Model\Mapeo;
use DB;
use PDF;
use Input;
use Excel;
use ActualPeriodo;
use Udla\Model\MapeoObservacion;
use Exception;

class ExportarController extends Controller
{

  	private $datos;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalConLogrosShow(){
      $rdaUniversidad = RdaUniversidad::all();
  		$logros = DB::select('Select ru.id, ru.rda_universidad, ru.logros FROM rda_universidad as ru');
  		$rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',Input::get('periodo'))->get();
  		$rdaUniCarrera = DB::select('select * from  rda_universidad_carrera as ruc INNER JOIN rda_carrera as ra where ra.carrera = ? and ruc.rda_carrera_id = ra.id', [Input::get('carrera')]);
  		$logrosCarrera = DB::select('Select rucl.logro_carrera, rucl.rda_uni_id FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru WHERE rucl.rda_uni_id=ru.id and carrera_codigo = ?',[Input::get('carrera')]);
  		$datos = array(
  			'rdaUniversidad' => $rdaUniversidad,
  			'rdaCarrera' => $rdaCarrera,
  			'rdaUniCarrera' => $rdaUniCarrera,
  			'logros' => $logros,
  			'logrosCarrera' => $logrosCarrera,
  			'carrera' => Input::get('carrera'),
  			'periodo' => Input::get('periodo')
  		);
      ini_set('memory_limit', '-1');
      libxml_use_internal_errors(true);
      $pdf = PDF::loadView('pdf.LogrosCarrera.index', ['datos'=> $datos])->setOrientation('portrait');
    	return $pdf->stream('Matriz en cascada de los Resultados de aprendiza y Estándares de Logro Institucionales VS Carrera.pdf');
     //return view('pdf.LogrosCarrera.index')->with('datos',$datos);
    }

    public function generalConLogrosShowExcel(){
      $rdaUniversidad = RdaUniversidad::all();
  		$logros = DB::select('Select ru.id, ru.rda_universidad, ru.logros FROM rda_universidad as ru');
  		$rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',Input::get('periodo'))->get();
  		$rdaUniCarrera = DB::select('select * from  rda_universidad_carrera as ruc INNER JOIN rda_carrera as ra where ra.carrera = ? and ruc.rda_carrera_id = ra.id', [Input::get('carrera')]);
  		$logrosCarrera = DB::select('Select rucl.logro_carrera, rucl.rda_uni_id FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru WHERE rucl.rda_uni_id=ru.id and carrera_codigo = ?',[Input::get('carrera')]);
  		$datos = array(
  			'rdaUniversidad' => $rdaUniversidad,
  			'rdaCarrera' => $rdaCarrera,
  			'rdaUniCarrera' => $rdaUniCarrera,
  			'logros' => $logros,
  			'logrosCarrera' => $logrosCarrera,
  			'carrera' => Input::get('carrera'),
  			'periodo' => Input::get('periodo')
  		);

      //return view('excel.LogrosCarrera.index')->with('datos',$datos);
     return 	Excel::create('Matriz en cascada de los Resultados de aprendiza y Estándares de Logro Institucionales VS Carrera', function($excel) use($datos) {

       $excel->sheet('Mapeo de la carrera', function($sheet) use($datos) {

           $sheet->loadView('excel.LogrosCarrera.index')->with('datos',$datos);

       });
       $lastrow= $excel->getActiveSheet()->getHighestRow();
       $excel->getActiveSheet()->getStyle('A1:D'.$lastrow)->getAlignment()->setWrapText(true);

     })->export('xls');
    }

    public function exportarRdaCarreraInstitucionales()
    {
      $rdaUniversidad = RdaUniversidad::all();
      $rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->get();
      $rdaUniCarrera = DB::select('select * from  rda_universidad_carrera as ruc INNER JOIN rda_carrera as ra where ra.carrera = ? and ruc.rda_carrera_id = ra.id', [Input::get('carrera')]);
      $materias= DB::select('Select DISTINCT m.nombre_materia, ru.id FROM materia as m INNER JOIN carrera_materia as cm, periodo_materia as pm, periodo as p, rda_periodo_materia as rpm, rda_carrera as rc, rda_universidad as ru, rda_universidad_carrera as ruc WHERE cm.cod_carrera=? and cm.cod_materia=m.codigo_materia and p.estado=1 and p.codigo=pm.periodo and pm.c_materia=cm.id and rpm.periodo_materia=pm.id and rc.carrera=cm.cod_carrera and ruc.rda_carrera_id=rc.id and ru.id=ruc.rda_universidad_id ORDER BY ru.id asc', [Input::get('carrera')]);
      $datos = array( 'rdaUniversidad' => $rdaUniversidad, 'rdaCarrera' => $rdaCarrera, 'rdaUniCarrera' => $rdaUniCarrera, 'materias' => $materias,'carrera'=>Input::get('carrera'));

      ini_set('memory_limit', '-1');
      libxml_use_internal_errors(true);
      $pdf = PDF::loadView('pdf.MateriaRdaCInstitucionales.index', ['datos'=> $datos])->setOrientation('portrait');
      return $pdf->stream('Tabla de resumen de asignaturas que aportan a los Resultados de aprendizaje de Carrera e Institucional.pdf');
      //return view('pages.Reportes.mostrar')->with('datos',$datos);
    }

    public function exportarRdaCarreraInstitucionalesExcel()
    {
      $rdaUniversidad = RdaUniversidad::all();
  		$rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo', Input::get('periodo'))->get();
  		$rdaUniCarrera = DB::select('select * from  rda_universidad_carrera as ruc INNER JOIN rda_carrera as ra where ra.carrera = ? and ruc.rda_carrera_id = ra.id', [Input::get('carrera')]);
  		$materias= DB::select('Select DISTINCT m.nombre_materia, ru.id FROM materia as m INNER JOIN carrera_materia as cm, periodo_materia as pm, periodo as p, rda_periodo_materia as rpm, rda_carrera as rc, rda_universidad as ru, rda_universidad_carrera as ruc WHERE cm.cod_carrera=? and cm.cod_materia=m.codigo_materia and p.estado=1 and p.codigo=pm.periodo and pm.c_materia=cm.id and rpm.periodo_materia=pm.id and rc.carrera=cm.cod_carrera and ruc.rda_carrera_id=rc.id and ru.id=ruc.rda_universidad_id ORDER BY ru.id asc', [Input::get('carrera')]);
  		$datos = array(
  			'rdaUniversidad' => $rdaUniversidad,
  			'rdaCarrera' => $rdaCarrera,
  			'rdaUniCarrera' => $rdaUniCarrera,
  			'materias' => $materias,
  			'carrera' => Input::get('carrera'),
  			'periodo' => Input::get('periodo')
  		);
      //return view('excel.LogrosCarrera.index')->with('datos',$datos);
     return 	Excel::create('Tabla de resumen de asignaturas que aportan a los Resultados de aprendizaje de Carrera e Institucional', function($excel)  use($datos) {

       $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

           $sheet->loadView('excel.MateriaRdaCInstitucionales.index')->with('datos',$datos);

       });
       $lastrow= $excel->getActiveSheet()->getHighestRow();
       $excel->getActiveSheet()->getStyle('A1:C'.$lastrow)->getAlignment()->setWrapText(true);

     })->export('xls');
    }

    public function rdaPerfilMaterias(){
      $rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->get();
      $materias= DB::select('Select DISTINCT m.codigo_materia, m.nombre_materia, rc.id, rpm.rda, rpm.nivel FROM materia as m
      INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, rda_carrera as rc, rda_periodo_materia as rpm WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and c.codigo = ? and rc.carrera = c.codigo and rpm.periodo_materia = pm.id and rpm.rda_carrera_id = rc.id order by rpm.nivel asc', [Input::get('carrera')]);
      $datos = [//array(
        'rdaCarrera' => $rdaCarrera,
        'rdaUniversidad' => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ?',[Input::get('carrera')]),
        'materias' => $materias,
        'carrera' => Input::get('carrera')
      ];//);
      //return view('pdf.PerfilMateria.index')->with('datos',$datos);
      ini_set('memory_limit', '-1');
      libxml_use_internal_errors(true);
      $pdf = PDF::loadView('pdf.PerfilMateria.index', ['datos'=> $datos])->setOrientation('portrait');
      return $pdf->stream('reporteRdaPerfilMaterias.pdf');
    }

    public function rdaPerfilMateriasExcel(){
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
      // return view('excel.rdaPerfilMateria.index')->with('datos',$datos);
      return 	Excel::create('Resultados de aprendizaje de las materias alineados a los RdA de  la carrera y RdA institucionales', function($excel)  use($datos) {

        $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

            $sheet->loadView('excel.rdaPerfilMateria.index')->with('datos',$datos);

        });
        $lastrow= $excel->getActiveSheet()->getHighestRow();
        $excel->getActiveSheet()->getStyle('A1:E'.$lastrow)->getAlignment()->setWrapText(true);

      })->export('xls');
    }

    public function observacionesMapeo(){
      $observaciones = DB::select("Select rc.id, rc.rda_carrera as rda, ma.observaciones as observacion FROM  rda_carrera as rc INNER JOIN mapeo as ma WHERE ma.carrera = ? and rc.id=ma.rda_carrera and rc.periodo=?", [Input::get('carrera'),Input::get('periodo')]);
  		$periodoActual = ActualPeriodo::getActualPeriodo()->codigo;
  		try
  		{
  			$observacion = MapeoObservacion::observacion(Input::get('carrera'),Input::get('periodo'))->observacion;
  		}catch(Exception $ex) {
  			$observacion = "";
  		}
  		$datos = [
  			'carrera' => Input::get('carrera'),
  			'observaciones' => $observaciones,
  			'observacion' => $observacion,
  			'periodo' => Input::get('periodo')
  		];
      $pdf = PDF::loadView('pdf.observacionesMapeo.pdf', ['datos'=> $datos])->setOrientation('portrait');
      return $pdf->stream('Observaciones del Mapeo de la malla curricular.pdf');
    }

    public function observacionesMapeoExcel(){
      $observaciones = DB::select("Select rc.id, rc.rda_carrera, ma.observaciones, ma.responsables FROM  rda_carrera as rc INNER JOIN mapeo as ma WHERE ma.carrera = ? and rc.id=ma.rda_carrera and ma.periodo=?", [Input::get('carrera'),Input::get('periodo')]);
  		$periodoActual = ActualPeriodo::getActualPeriodo()->codigo;
  		try
  		{
  			$observacion = MapeoObservacion::observacion(Input::get('carrera'),Input::get('periodo'))->observacion;
        $responsables = MapeoObservacion::observacion(Input::get('carrera'),Input::get('periodo'))->responsables;
  		}catch(Exception $ex) {
  			$observacion = "";
  		}
  		$datos = [
  			'carrera' => Input::get('carrera'),
  			'observaciones' => $observaciones,
        'responsables' => $responsables,
  			'observacion' => $observacion,
        'periodo' => Input::get('periodo')
  		];

      return  Excel::create('Observaciones del Mapeo de la malla curricular', function($excel)  use($datos){

        $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

            $sheet->loadView('excel.observacionesMapeo.index')->with('datos',$datos);

        });
        $lastrow= $excel->getActiveSheet()->getHighestRow();
        $excel->getActiveSheet()->getStyle('A1:B'.$lastrow)->getAlignment()->setWrapText(true);

      })->export('xls');
    }

    public function observacionesExcel(){
      $observaciones = DB::select("Select DISTINCT m.codigo_materia as materia, m.nombre_materia as nombre,pm.observacion, pm.responsables FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm, carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and rpm.periodo_materia = pm.id and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and (rpm.observaciones != 'Sin Observaciones' or pm.observacion != 'NULL') and (rpm.observaciones != ' ' or pm.observacion != ' ')", [Input::get('periodo'),Input::get('carrera')]);
      //$observacionesGenerales = DB::select("Select DISTINCT m.codigo_materia as materia, m.nombre_materia as nombre FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm, carrera_materia as cm, materia as m, periodo as p WHERE p.estado = 1 and p.codigo = pm.periodo and rpm.periodo_materia = pm.id and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and pm.observacion != ' ' Group by m.codigo_materia", [Input::get('carrera')]);

      $datos = [
        'carrera' => Input::get('carrera'),
        'observaciones' => $observaciones,
        'periodo' => Input::get('periodo')
      ];

      return  Excel::create('Observaciones Sílabos ingresados', function($excel)  use($datos){

        $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

            $sheet->loadView('excel.rdaObservaciones.index')->with('datos',$datos);

        });
        $lastrow= $excel->getActiveSheet()->getHighestRow();
        $excel->getActiveSheet()->getStyle('A1:C'.$lastrow)->getAlignment()->setWrapText(true);

      })->export('xls');
    }

    public function observacionesDetalleExcel($id,$carrera,$periodo){
      $observaciones = DB::select("Select rpm.id, rpm.rda, rpm.mde, rpm.nivel,rpm.observaciones,rpm.responsables, pm.observacion FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm, carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and rpm.periodo_materia = pm.id and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and rpm.observaciones != 'Sin Observaciones' and rpm.observaciones != ' ' and m.codigo_materia = ?", [$periodo,$carrera,$id]);
      $observacionesGenerales = DB::select("Select pm.observacion FROM periodo_materia as pm INNER JOIN carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and pm.observacion != ' ' and m.codigo_materia = ?", [$periodo,$carrera,$id]);
      $materia = DB::select("Select m.nombre_materia FROM periodo_materia as pm INNER JOIN carrera_materia as cm, materia as m, periodo as p WHERE p.codigo = ? and p.codigo = pm.periodo and pm.c_materia = cm.id and cm.cod_carrera = ? and cm.cod_materia = m.codigo_materia and m.codigo_materia = ? ", [$periodo,$carrera,$id])[0];
      $periodoMateria = PeriodoMateria::where('periodo',$periodo)
  		->whereHas('careerSignature', function($query) use($carrera,$id){
  			$query->where('cod_carrera',$carrera)->where('cod_materia',$id);
  		})->first();
      $datos = [
        'observaciones' => $observaciones,
        'observacionesGenerales' => $observacionesGenerales,
        'materia' => $materia,
        'periodoMateria' => $periodoMateria,
        'carrera' => $carrera,
        'periodo' => $periodo,
        'id' => Input::get('id')
      ];

      return  Excel::create('Observaciones Detalladas', function($excel)  use($datos){

        $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

            $sheet->loadView('excel.rdaObservaciones.detalle')->with('datos',$datos);

        });
        $lastrow= $excel->getActiveSheet()->getHighestRow();
        $excel->getActiveSheet()->getStyle('A1:D'.$lastrow)->getAlignment()->setWrapText(true);

      })->export('xls');
    }

    public function mapeo($id){
      $materias = DB::select("Select distinct pm.id,m.codigo_materia, m.nombre_materia, pm.semestre, m.organizacion_curricular, m.area_formacion, a.descripcion as area, pm.creditos, pm.prerequisito, pm.tipo_asignatura FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$id]);
  		$semestres = DB::select("Select pm.semestre FROM materia as m INNER JOIN periodo as p,periodo_materia as pm, carrera as c, carrera_materia as cm, area as a WHERE c.codigo = cm.cod_carrera and cm.cod_materia = m.codigo_materia and pm.periodo = p.codigo and p.estado = 1 and pm.c_materia = cm.id and a.id = m.organizacion_curricular and c.codigo = ? order by pm.semestre",[$id]);

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
  			"semestres" => $semestres,
  			"observaciones" => $observaciones,
        'carrera' => $id
  		);

  		//var_dump($materias[20]->prerequisitos[0]->materia_codigo);
  		//exit();
      ini_set('memory_limit', '-1');
      libxml_use_internal_errors(true);
      $pdf = PDF::loadView('pdf.mapeo.pdf', ['datos'=> $datos])->setOrientation('landscape');
      return $pdf->stream('Mapeo.pdf');
    /*  $view =  \View::make('pdf.mapeo.pdf', compact('datos'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream('Mapeo.pdf');*/
  		//return view('pdf.mapeo.pdf')->with('datos',$datos);
    }

    public function RDAPerfilMateriaConsolidado(){
      $rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',Input::get('periodo'))->get();
  		$niveles=DB::select('call spReporteConsolidado(?,?)',[Input::get('carrera'),Input::get('periodo')]);
  		$datos = [//array(
  			'rdaCarrera' => $rdaCarrera,
  			'rdaUniversidad' => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ? and rc.periodo = ?',[Input::get('carrera'), Input::get('periodo')]),
  			'niveles' => $niveles,
  			'carrera' => Input::get('carrera'),
  			'periodo' => Input::get('periodo')
  		];
    ini_set('memory_limit', '-1');
    libxml_use_internal_errors(true);

    if( Input::get('carrera') == 5){
        $pdf = PDF::loadView('pdf.rdaConsolidado.consolidado', ['datos'=> $datos])->setOrientation('landscape');
    }else{
        $pdf = PDF::loadView('pdf.rdaConsolidado.consolidado', ['datos'=> $datos])->setOrientation('portrait');
    }
    return $pdf->stream('Reporte consolidado de mapeo curricular por niveles de logro.pdf');

    }

    public function RDAPerfilMateriaConsolidadoExcel(){
      $rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',Input::get('periodo'))->get();
  		$niveles=DB::select('call spReporteConsolidado(?,?)',[Input::get('carrera'),Input::get('periodo')]);
  		$datos = [//array(
  			'rdaCarrera' => $rdaCarrera,
  			'rdaUniversidad' => DB::select('SELECT rc.id, ru.rda_universidad FROM rda_universidad_carrera as ruc INNER JOIN rda_universidad as ru, rda_carrera as rc WHERE ruc.rda_universidad_id = ru.id and rc.id = ruc.rda_carrera_id and rc.carrera = ? and rc.periodo = ?',[Input::get('carrera'), Input::get('periodo')]),
  			'niveles' => $niveles,
  			'carrera' => Input::get('carrera'),
  			'periodo' => Input::get('periodo')
  		];

    return  Excel::create('Reporte consolidado de mapeo curricular por niveles de logro', function($excel)  use($datos) {

        $excel->sheet('Mapeo de la carrera', function($sheet)  use($datos) {

            $sheet->loadView('excel.rdaConsolidado.consolidado')->with('datos',$datos);

        });
        $lastrow= $excel->getActiveSheet()->getHighestRow();
        $excel->getActiveSheet()->getStyle('A1:D'.$lastrow)->getAlignment()->setWrapText(true);

      })->export('xls');
    }
}
