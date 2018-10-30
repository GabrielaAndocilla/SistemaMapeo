<?php

namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class MapeoObservacion extends Model
{
  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'mapeo_observacion';

  public function carrera()
  {
    return $this->hasOne('Udla\Model\Career');
  }

  public function periodo()
  {
    return $this->hasOne('Udla\Model\Periodo');
  }

  public function scopeObservacion($query, $carreraId, $periodoId){
    return $query->where('carrera',$carreraId)->where('periodo',$periodoId)->firstOrFail();
  }
}
