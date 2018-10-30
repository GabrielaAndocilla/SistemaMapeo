<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Udla\Model\RdaCarrera;
use Udla\Factory\RdaCarreraFactory;
use Udla\Model\Career;
use Udla\Model\Signature;
use Input;
use Auth;
use DB;
use Log;
use Udla\Model\Periodo;
use Udla\Model\RdaUniversidad;
use ActualPeriodo;
use Udla\Model\Logro;

class RdaCarreraController extends Controller {

	protected $factory;

	public function __construct(RdaCarreraFactory $factory)
	{
		$this->factory = $factory;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(Auth::user()->career == Input::get('carrera') || Auth::user()->type == 99){
			$rdaCarrera = RdaCarrera::where('carrera', Input::get('carrera'))->where('periodo',ActualPeriodo::getActualPeriodo()->codigo)->get();
			$datos = array(
				'rdas' => $rdaCarrera,
				'carrera' => Input::get('carrera')
			);
			return view('pages.rdaCarrera.index')->with('datos', $datos);
		}else{
			Log::warning("Usuario ".Auth::user()->id." ha intentado acceder");
			return view('errors.401');
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function consulta_logros()
	{
		$carrers = Career::all();
		$datos = [
			'carreras' => $carrers,
			'periodos' => Periodo::all()
		];
		return view('pages.Reportes.LogrosCarrera.consulta')->with('datos',$datos);
	}

	public function mostrar_logros()
	{
		//$logros = DB::select(
		//"Select rucl.id, ru.rda_universidad, rucl.logro_carrera 
		//FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru 
		//WHERE ru.id=rucl.rda_uni_id and rucl.carrera_codigo=? and ru.periodo_id", [Input::get('carrera'), ActualPeriodo::getActualPeriodo()->codigo]);
		//dd($logros);
		$logros = Logro::whereHas('rdaUniversidad', function($q){
			$q->where('periodo_id', ActualPeriodo::getActualPeriodo()->codigo);
		})->where('carrera_codigo',Input::get('carrera'))->get();
		//dd($logros);
		$data = array(
			'logros' => $logros,
			'carrera' => Input::get('carrera')
			);
		return view('pages.Reportes.LogrosCarrera.mostrar')->with('datos', $data);
	}

	public function insertar_logros($id){
		$datos = array(
			'carrera' => $id,
			'rdaUniversidad' => RdaUniversidad::getCurrentRdas(),
			'rdaUniversidadIngresados' => DB::select("Select rucl.id, ru.id as idRuc,ru.rda_universidad, rucl.logro_carrera FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru WHERE ru.id=rucl.rda_uni_id and rucl.carrera_codigo=?", [$id])
		);
		return view('pages.Reportes.LogrosCarrera.insertar')->with('datos', $datos);
	}

	public function editar_logros($id){
		$logro = DB::table('rda_uni_carrera_logro')->where('id', '=', $id)->get()[0];
		$datos = array(
			'carrera' => $logro->carrera_codigo,
			'rdaUniversidad' => RdaUniversidad::getCurrentRdas(),
			'rdaUniversidadIngresados' => DB::select("Select rucl.id, ru.id as idRuc,ru.rda_universidad, rucl.logro_carrera FROM rda_uni_carrera_logro as rucl INNER JOIN rda_universidad as ru WHERE ru.id=rucl.rda_uni_id and rucl.carrera_codigo=?", [$logro->carrera_codigo]),
			'rul' => $logro
		);
		return view('pages.Reportes.LogrosCarrera.edit')->with('datos', $datos);
	}

	public function update_logros($id){
		$logro = DB::table('rda_uni_carrera_logro')->where('id', '=', $id)->get()[0];
		$update = DB::table('rda_uni_carrera_logro')->where('id', $id)->update(['logro_carrera' => Input::get('logrordacarreras'), 'rda_uni_id' => Input::get('rdaUniversidad')]);

		if($update){
			$url = "/gestionar/ingreso-logros-carrera/mostrar?carrera=".$logro->carrera_codigo;
			return redirect($url)->with('mensaje', 'Actualizacion exitosa');
		}else{
			$url = "/gestionar/ingreso-logros-carrera/mostrar?carrera=".$logro->carrera_codigo;
			return redirect($url)->with('warning', 'No se ha actualizado');
		}
	}

	public function store_logro($id){
		$ingreso = DB::table('rda_uni_carrera_logro')->insert([
			  ['rda_uni_id' => Input::get('rdaUniversidad'),
				 'carrera_codigo' => $id,
				 'logro_carrera' => Input::get('logrordacarreras') ]
			]);
			if($ingreso){
				$url = "/gestionar/ingreso-logros-carrera/mostrar?carrera=".$id;
				return redirect($url)->with('mensaje', 'Ingreso exitoso');
			}else{
				$url = "/gestionar/ingreso-logros-carrera/mostrar?carrera=".$id;
				return redirect($url)->with('warning', 'No se ingreso');
			}
	}

	public function destroy_logro($id){
		$logro = DB::table('rda_uni_carrera_logro')->where('id', '=', $id)->get()[0];
		$car = $logro->carrera_codigo;
		$logroName = $logro->logro_carrera;
		$logro = DB::table('rda_uni_carrera_logro')->where('id', '=', $id)->delete();


		$url = "/gestionar/ingreso-logros-carrera/mostrar?carrera=".$car;
		$mensaje = "Se ha elimiado $logroName!";
		return redirect($url)->with('warning', $mensaje);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$carreras=Career::all();
		$rda = RdaCarrera::where('id',$id)->get()[0];
		foreach ($carreras as $carrera){
			if($carrera->codigo == $rda->carrera){
				$rda->nombreCarrera = $carrera->nombre;
			}
		}

		$rdaUniversidad = DB::select('Select * from rda_universidad_carrera where rda_carrera_id = ?', [$rda->id]);
		$rdaUniversidades = RdaUniversidad::getCurrentRdas();
		foreach ($rdaUniversidad as $ruf) {
			foreach ($rdaUniversidades as $ru) {
				if($ru->id == $ruf->rda_universidad_id){
					$ruf->nombreRdaUniversidad = $ru->rda_universidad;
				}
			}
		}

		$rdaUniversidadNoEscogidos = RdaUniversidad::getCurrentRdas();
		foreach ($rdaUniversidadNoEscogidos as $i=>$posibleEscogido)
		{
			foreach ($rdaUniversidad as $escogido) {
					if($posibleEscogido->id == $escogido->rda_universidad_id)
					{
						unset($rdaUniversidadNoEscogidos[$i]);
					}
			}
		}

		// print_r($rdaUniversidadNoEscogidos);
		// exit;
		$datos = array(
			'rda' => $rda,
			'rdaUniversidadEscogidas' =>  $rdaUniversidad,
			'rdaUniversidadNoEscogidos' => $rdaUniversidadNoEscogidos
		);
		return view ('pages.rdaCarrera.edit')->with('datos', $datos);
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
			$rda = RdaCarrera::where('id',$id)->get()[0];
			$rda->rda_carrera = Input::get('rda');
			$rda->user_updated = Auth::user()->id;
			$rda->save();

			// Buscar y borrar
			DB::table('rda_universidad_carrera')->where('rda_carrera_id', '=', $rda->id)->delete();
			//Ingresar
			if(Input::get('rdauniversidad') != null){
				foreach(Input::get('rdauniversidad') as $rdaUni){
					$id = DB::table('rda_universidad_carrera')->insertGetId(array(
						'rda_carrera_id' => $rda->id,
						 'rda_universidad_id' => $rdaUni,
						 'created_at'=> date_create()->format('Y-m-d H:i:s'),
						 'user_created' => Auth::user()->id
					 ));
				}
			}
			$url = "/gestionar/rda-carreras/listar?carrera=".$rda->carrera;
			return redirect($url)->with('mensaje', 'Actualización exitosa');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
			$rda = RdaCarrera::where('id',$id)->get()[0];
			$rda->delete();

			$url = "/gestionar/rda-carreras/listar?carrera=".$rda->carrera;
			$mensaje = "Se ha elimiado $rda->rda_carrera!";
			return redirect($url)->with('warning', $mensaje);
	}

	public function consultar(){
		if(Auth::user()->type == 99){
			$carreras=Career::all();
			return view ('pages.rdaCarrera.consultar')->with('carreras', $carreras);
		}else{
			return redirect("/gestionar/rda-carreras/listar?carrera=".Auth::user()->career);
		}

	}

	public function guardado($id)
	{
		if(Auth::user()->career == $id || Auth::user()->type == 99){
			$rdaUniversidad = RdaUniversidad::getCurrentRdas();
			$carreras=Career::all();
			$datos = array(
				'carreras' => $carreras,
				'cod' => $id,
				'rdasUniversidad' => $rdaUniversidad
			);
			return view ('pages.rdaCarrera.insert')->with('datos', $datos);
		}else{
			Log::warning("Usuario ".Auth::user()->id." ha intentado acceder");
			return view('errors.401');
		}
	}

	public function guardar(Request $request)
	{
		if(Auth::user()->career == Input::get('carrera') || Auth::user()->type == 99)
		{
			if(Input::get('rdauniversidad') != 1 )
			{
				$request['user_created'] = Auth::user()->id;
				$request['periodo'] = ActualPeriodo::getActualPeriodo()->codigo;
				$reponse =  $this->factory->create($request->all());
				if($reponse['created'])
				{
						$url = "/gestionar/rda-carreras/listar?carrera=".Input::get('carrera');
				 		return redirect($url)->with('mensaje', 'Ingreso exitoso');
				}else
				{
				 		$url = "/gestionar/rda-carreras/".Input::get('carrera')."/insertar";
						return redirect($url)->with('warning', $reponse['error']);
					}
			}else
			{
				 	$url = "/gestionar/rda-carreras/".Input::get('carrera')."/insertar";
				 	return redirect($url)->with('warning', 'Debe añadir un RDA institucional.');
			}
		}
		else
		{
			Log::warning("Usuario ".Auth::user()->id." ha intentado acceder");
			return view('errors.401');
		}
	}
}
