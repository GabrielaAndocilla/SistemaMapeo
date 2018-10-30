<?php namespace Udla\Http\Controllers;

use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Udla\Model\RdaPeriodo;

class RdaPeriodoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	 * DEPRECATED
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$rda = RdaPeriodo::where('periodo_materia', '=' , $request->perido_m)->get();
		for($i=0;$i<count($rda);$i++){
			$rda[$i]->delete();
		}
		for($j=0;$j<count($request->datos);$j++)
	  	{
				$rda = new RdaPeriodo();
				$rda->periodo_materia = $request->perido_m;
				$rda->rda = $request->datos[$j]["rda materia"];
				$rda->mde = $request->datos[$j]["mde"];
				$rda->nivel = $request->datos[$j]["nivel"];
				$rda->observaciones = $request->datos[$j]["observaciones"];
				$rda->responsables = $request->datos[$j]["responsables"];
				if($request->datos[$j]["rda carrera"] != 0){
						$rda->rda_carrera_id = $request->datos[$j]["rda carrera"];
				}else{
					if(	$rda->observaciones == null || 	$rda->observaciones == "Sin observaciones"){
						return response()->json([
							"msg" => "Si el RDA de la carrera no existe debe ingresar una observación"
						],400);
					}
				}
				$rda->save();
	  	}
		return response()->json([
			"msg" => "Success"
		],200);
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
