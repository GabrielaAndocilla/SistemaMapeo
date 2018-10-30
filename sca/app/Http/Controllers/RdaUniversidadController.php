<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Udla\Model\RdaUniversidad;

use Input;
use Illuminate\Http\Request;
use ActualPeriodo;

class RdaUniversidadController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rdaUniversidad = RdaUniversidad::getCurrentRdas();
		return view('pages.rdaUniversidad.index')->with('rdaUniversidad', $rdaUniversidad);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pages.rdaUniversidad.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rdaUniversidad = new RdaUniversidad();
		$rdaUniversidad->rda_universidad = Input::get('rda');
		$rdaUniversidad->rda_universidad_abrev = Input::get('rdaAbreviado');
		$rdaUniversidad->logros = Input::get('logrouniversidad');
		$codigo_periodo = ActualPeriodo::getActualPeriodo()->codigo;
		$rdas =  RdaUniversidad::where('periodo_id', $codigo_periodo)->get();
		$url = "/gestionar/rda-universidad";
		if($rdas == null || $rdas->isEmpty()){
			if($rdaUniversidad->save()){
				return redirect($url)->with('mensaje', 'Ingreso exitoso');
			}
			return redirect($url)->with('warning', 'Ingreso fallido');
		}
		$rdaUniversidad->periodo_id = $codigo_periodo;
		if($rdaUniversidad->save()){
			return redirect($url)->with('mensaje', 'Ingreso exitoso');
		}
		return redirect($url)->with('warning', 'Ingreso fallido');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$rdaUniversidad = new RdaUniversidad();
		$rdaUniversidad->logrosRdaCarreras = Input::get('logrordacarreras');
		if($rdaUniversidad->save()){
			return redirect($url)->with('mensaje', 'Ingreso exitoso');
		}else{
			return redirect($url)->with('warning', 'Ingreso fallido');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$rdaUniversidad = RdaUniversidad::where('id',$id)->get()[0];
		return view('pages.rdaUniversidad.edit')->with('rda',$rdaUniversidad);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rdaUniversidad = RdaUniversidad::where('id',$id)->get()[0];
		$rdaUniversidad->rda_universidad = Input::get('rda');
		$rdaUniversidad->logros = Input::get('logrouniversidad');
		$rdaUniversidad->rda_universidad_abrev = Input::get('rdaAbreviado');
		$url = "/gestionar/rda-universidad";
		if($rdaUniversidad->save()){
			return redirect($url)->with('mensaje', 'Actualización exitosa');
		}else{
			return redirect($url)->with('warning', 'No se ha podido actualizar');
		}
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
		$rdaUniversidad = RdaUniversidad::where('id',$id)->get()[0];
		$url = "/gestionar/rda-universidad";
		if($rdaUniversidad->delete()){
			return redirect($url)->with('warning', 'Se ha eliminado el rda');
		}else{
			return redirect($url)->with('warning', 'No se ha podido eliminar el rda');
		}
	}

}
