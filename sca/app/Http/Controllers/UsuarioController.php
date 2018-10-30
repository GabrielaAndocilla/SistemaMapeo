<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Udla\Model\User;
use Auth;
use DB;
use Udla\Model\Career;
use Input;

class UsuarioController extends Controller {


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
	 * @param  int  $id
	 * @return Response
	 */
	public function getById($id)
	{
		//
		if(Auth::user()->id == $id){
			$data = User::where('id','=',$id)->firstOrFail();
			return view('pages.perfil.index')->with('data', $data);
		}else{
			return view('errors.401');
		}

	}

	public function consultar(){
		$carrers = Career::all();
		return view('pages.usuario.consulta')->with('carreras',$carrers);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$usuarios = DB::select('SELECT id, name as nombre, email as correo, type as tipo, career as carrera FROM users');
		$carreras = Career::all();
		$datos = array('usuarios' => $usuarios,'carreras' => $carreras);
		return view('pages.usuario.index')->with('datos', $datos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		//
		$id = Input::get('carrera');
		$usuarios = DB::select('SELECT id, name as nombre, email as correo, type as tipo, career as carrera FROM users WHERE career=?',[$id]);
		$carreras = Career::all();
		$datos = array('usuarios' => $usuarios,'carreras' => $carreras,'carrera' => $id);
		return view('pages.usuario.show')->with('datos', $datos);
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
	}

}
