<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Udla\Model\Career;

use Input;
use Illuminate\Http\Request;
use Udla\Factory\PeriodoFactory;

class SilaboController extends Controller {

	protected $periodoFactory;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(PeriodoFactory $periodoFactory)
	{
		$this->middleware('auth');
		$this->periodoFactory = $periodoFactory;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function carreras(){

		$carrers = Career::all();
		$data = [
			'carreras' => $carrers
		];
		return view('pages.silabo.carreras')->with('datos', $data);
	}

	public function consultar(){
		$carrers = Career::all();
		return view('silabos.consulta')->with('carreras',$carrers);
	}
	public function mostrarSilabos(){

		$pActual = $this->periodoFactory->getActualPeriodo();

		if(Input::get('carrera') == 1){
			return view('silabos.sistemas.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 2){
			return view('silabos.sonido.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 3){
			return view('silabos.electronica.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 4){
			return view('silabos.agroindustria.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 5){
			return view('silabos.produccion.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 6){
			return view('silabos.ambiental.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 7){
			return view('silabos.bio.index')->with('actual_periodo',$pActual);
		}
		if(Input::get('carrera') == 8){
			return view('silabos.redes.index')->with('actual_periodo',$pActual);
		}
	}
	public function listDetails($id){
		$data = Career::where('codigo','=',$id)->firstOrFail();
		return view('pages.silabo.detalle')->with('data', $data);

	}



}
