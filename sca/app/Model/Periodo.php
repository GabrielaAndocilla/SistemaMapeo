<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model {

	//
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'periodo';

	protected $fillable = [
		'codigo',
    'year',
    'period',
    'p_anterior',
		'estado'
	];

	public function observacionesMapeos()
	{
			return $this->hasMany('Udla\Model\MapeoObservacion');
	}

}
