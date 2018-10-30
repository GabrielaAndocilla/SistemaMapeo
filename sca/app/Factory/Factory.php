<?php

namespace Udla\Factory;

use Udla\Factory\iFactory;
use Validator;

abstract class Factory implements iFactory{

    /**
    * This method update the model
    * @param {int}   id
    * @param {Array} data
    * @return {Boolean} true/false
    */
    public function updateModel($id,$data){
        $model = $this->model->find($id);
        $model->update($data);
        return $model;
    }

    public function getAll()
    {
      return $this->model->all();
    }

    /**
    * This method save the model
    * @param {Array} data
    * @return Model
    */
    public function insertModel($data){
        $model = $this->model->create($data);
        return $model;
    }

    public function create($data)
    {
      $validation = Validator::make($data, $this->rules);

      if ($validation->fails())
      {
        //return Response::make($validation->errors->first(), 400);
          return ['created' => false, 'errors' => $validation->errors->first()];
      }else
      {
        $model = $this->model->create($data);
        return ['created' => true];
      }
    }

    public function getAllByParentId($parent){
        return $this->model->where($parent['foreign'],$parent['value'])->get();
    }

    public function remove($id){
        $item = $this->model->find($id);
        $removed = $item->delete();
        if($removed)
          $data = ["result"=>"success","message"=>"El ítem ha sido removido exitosamente!"];
        else
          $data = ["result"=>"fail","message"=>"El ítem no se ha podido remover"];
        return $data;
    }

    public function getById($id){
        return $this->model->find($id)->toArray();
    }

}
