<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class CareerSignature extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'carrera_materia';


  public function career(){
    return $this->belongsTo(Career::class,'cod_carrera','codigo');
  }

  public function signature(){
		return $this->belongsTo(Signature::class,'cod_materia','codigo_materia');
  }
  
  public function periodoMaterias(){
		return $this->belongsTo(PeriodoMateria::class,'id','c_materia');
  }


}
