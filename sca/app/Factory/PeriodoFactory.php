<?php
namespace Udla\Factory;

use Udla\Model\Periodo;
use Validator;
use DB;

class PeriodoFactory extends Factory implements iPeriodoFactory{


  protected $rules = [
    'codigo'=>'required|string|max:6|unique:periodo',
    'year'=>'required|integer',
    'period' => 'required|integer|max:4',
    'p_anterior' => 'string|max:6'
  ];


  public function __construct(Periodo $model)
  {
    $this->model = $model;
  }

  public function create($data)
  {
    $data['codigo'] = $data['year'].'_'.$data['period'];
    $validation = Validator::make($data, $this->rules);

    if ($validation->fails())
    {
      //return Response::make($validation->errors->first(), 400);
        return $validation->errors()->first();
    }else
    {
      $m = $this->model;
      $tx = DB::transaction(function() use($data,$m){
        $model = $m->create($data);
        DB::select("call spSincronizarPeriodo(?,?)", [$model->p_anterior, $model->codigo]);
        return true;
      });
      if ($tx)
      {
        return "Se ha creado el período, si desea activarlo, ir a Seleccionar Período.";
      }
      else {
        return "Ha ocurrido un error";
      }
    }
  }

  public function getActualPeriodo()
  {
    return Periodo::where('estado', '=', 1)->firstOrFail();
  }

}
