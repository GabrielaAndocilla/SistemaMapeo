<?php

namespace Udla\Http\Controllers;

use Illuminate\Http\Request;
use Udla\Http\Requests;
use Udla\Http\Controllers\Controller;
use Udla\Model\Periodo;
use Udla\Factory\PeriodoFactory;
use Redirect;
use Input;
use DB;
use Auth;

class PeriodoController extends Controller
{

    private $factory;

    public function __construct(PeriodoFactory $factory)
    {
      $this->middleware('auth');
      $this->factory = $factory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
      if(Auth::user()->type == 99){
        $periodos=Periodo::all();
        $periodo_actual = $this->factory->getActualPeriodo();
        return view('parametros.periodo.index')->with('data', ['periodos' => $periodos, 'actual' => $periodo_actual]);
      }else{
        return view('errors.401');
      }

    }

    public function postIndex(Request $request)
    {
      if(Auth::user()->type == 99){
        DB::select("CALL spCambiarPeriodo(?)",[Input::get('periodo')]);
      }
      return Redirect::back()->withMessage('Periodo Cambiado');
    }

    public function getAdd()
    {
      $periodos = $this->factory->getAll();
        $periodo_actual = $this->factory->getActualPeriodo();
      return view('parametros.periodo.add')->with('data',['periodos' => $periodos, 'actual' => $periodo_actual]);
    }

    public function postAdd(Request $request)
    {
      return Redirect::back()->with('message',$this->factory->create($request->all()));
    }

}
