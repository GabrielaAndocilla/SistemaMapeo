<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class RdaCarrera extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rda_carrera';

	protected $fillable = [
		'carrera',
		'periodo',
		'rda_carrera',
		'user_created',
		'user_updated'
	];

	public function rdas_universidad()
	{
		return $this->belongsToMany(RdaUniversidad::class, 'rda_universidad_carrera', 'rda_carrera_id', 'rda_universidad_id')->withPivot('user_created');
	}

	public function periodSignatures(){
		return $this->belongsToMany(PeriodoMateria::class, 'rda_periodo_materia', 'rda_carrera_id', 'periodo_materia')->withPivot('rda');
	}

}