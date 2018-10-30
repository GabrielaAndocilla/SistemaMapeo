<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class Career extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'carrera';

	/**
	*	Declarate the relationship One to Many
	*
	*
	*/
	public function observacionesMapeos()
	{
		return $this->hasMany('Udla\Model\MapeoObservacion');
	}
	/**
 	*	Get Carrera Info
 	*	@params id $id
 	* @return \Udla\Model\Career
 	*/
	public function scopeCarrera($query,$id)
	{
		return $query->where('codigo',$id)->firstOrFail();
	}
}
