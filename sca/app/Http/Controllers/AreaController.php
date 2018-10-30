<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Udla\Model\Career;
use DB;
use Udla\Model\Area;
use Input;
use Auth;

class AreaController extends Controller {


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
	public function index()
	{
		//
		$areas = Area::where('carrera_codigo',Input::get('carrera'))->get();
		$datos = array(
			'areas' => $areas,
			'carrera' => Input::get('carrera')
		);
		return view('pages.area.index')->with('datos',$datos);
	}

	public function consultar(){
		$carreras = Career::all();
		return view('pages.area.consultar')->with('carreras',$carreras);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//
		$carreras = Career::all();
		$datos = array(
			'carreras' => $carreras,
			'cod' => $id
		);
		return view('pages.area.create')->with('datos',$datos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$area = Area::where('descripcion',Input::get('area'));
		//if(count($area) > 0){
			//TODO: validar
		//}
		$area = new Area();
		$area->descripcion = Input::get('area');
		$area->carrera_codigo = Input::get('carrera');
		$area->user_created = Auth::user()->id;
		$area->save();

		$url = "/gestionar/areas/listar?carrera=".Input::get('carrera');
		return redirect($url)->with('mensaje', 'Ingreso exitoso');

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
		//
		$carreras = Career::all();
		$area = Area::where('id',$id)->get()[0];
		foreach ($carreras as $carrera){
			if($carrera->codigo == $area->carrera_codigo){
				$area->nombreCarrera = $carrera->nombre;
			}
		}

		return view('pages.area.edit')->with('area',$area);


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
		$area = Area::where('id',$id)->get()[0];
		$area->descripcion = Input::get('area');
		$area->user_updated = Auth::user()->id;
		$area->save();

		$url = "/gestionar/areas/listar?carrera=".$area->carrera_codigo;
		return redirect($url)->with('mensaje', 'Actualizacion exitosa!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$area = Area::where('id',$id)->get()[0];
		$desc = $area->descripcion;
		$area->delete();

		$url = "/gestionar/areas/listar?carrera=".$area->carrera_codigo;
		$mensaje = "Se ha elimiado $desc!";
		return redirect($url)->with('warning', $mensaje);

	}

	public function apiListarAreas($id){
		$areas = Area::where('carrera_codigo','=',$id)->get();
		return response()->json($areas,200);
	}

}
