<?php
namespace App\Repositories;
abstract class Repository {

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
