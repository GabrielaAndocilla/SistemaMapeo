<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class PeriodoMateria extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'periodo_materia';

	public function careerSignature(){
		return $this->belongsTo(CareerSignature::class,'c_materia','id');
	}

	public function period(){
		return $this->belongsTo(Periodo::class,'periodo','codigo');
	}
	
	public function rdaPeriodoMateria(){
		return $this->belongsTo(RdaPeriodo::class,'id','periodo_materia');
	}
	
}
