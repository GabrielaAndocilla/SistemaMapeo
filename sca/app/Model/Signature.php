<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'materia';
	
	public function carrerSignatures(){
		return $this->belongsTo(CareerSignature::class,'codigo_materia','cod_materia');
	}
}