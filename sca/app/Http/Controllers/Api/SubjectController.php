<?php

namespace Udla\Http\Controllers\Api;


use Illuminate\Http\Request;
use Udla\Model\RdaPeriodo;

class SubjectController extends ApiController {

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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//

		foreach ($request->datos as $dato) {
			if(empty($dato["responsables"])){
				return response()->json([
					"msg" => "Debe ingresar un responsable"
				],400);
			}
		}
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
					if(	$rda->observaciones == null || 	$rda->observaciones == "Sin observaciones" || $rda->responsables == null || $rda->responsables == "Sin responsables"){
						return response()->json([
							"msg" => "Si el RDA de la carrera no existe debe ingresar una observación y un responsable"
						],400);
					}
				}
				if(	!($rda->observaciones == null || 	$rda->observaciones == "Sin observaciones") && ($rda->responsables == null || $rda->responsables == "Sin responsables")){
					return response()->json([
						"msg" => "Debe ingresar un responsable!"
					],400);
				}
				$rda->save();
	  	}
		return response()->json([
			"msg" => "Success"
		],200);
	}


}
