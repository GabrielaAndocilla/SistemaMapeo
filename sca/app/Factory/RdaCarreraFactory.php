<?php

namespace Udla\Factory;

use Udla\Model\RdaCarrera;
use Validator;
use DB;

class RdaCarreraFactory extends Factory
{
  protected $rules = [
    'carrera' => 'required|integer',
    'periodo' => 'required|string|max:6',
    'rda_carrera'=>'required|string'
  ];

  public function __construct(RdaCarrera $model)
  {
    $this->model = $model;
  }

  public function create($data)
  {
    $validation = Validator::make($data, $this->rules);

    if ($validation->fails())
    {
      //return Response::make($validation->errors()->first(), 400);
        return ['created' => false, 'error' => $validation->errors()->first()];
    }else
    {
      $rdasUniversidad  = (array)$data['rdauniversidad']; // related ids
      $pivotData = array_fill(0, count($rdasUniversidad), ['user_created' => $data['user_created']]);
      $syncData  = array_combine($rdasUniversidad, $pivotData);
      $m = $this->model;
      DB::transaction(function () use ($m,$data,$syncData) {
        $model= $m->create($data);
        $model->rdas_universidad()->sync($syncData);
      });
      return ['created' => true];
    }
  }

}
