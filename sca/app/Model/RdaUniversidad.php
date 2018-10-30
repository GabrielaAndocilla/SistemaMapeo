<?php namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;
use ActualPeriodo;
class RdaUniversidad extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rda_universidad';

	public static function getRdasPorPeriodo($codigo_periodo){
		$rdas =  RdaUniversidad::where('periodo_id', $codigo_periodo)->get();
		if($rdas == null || $rdas->isEmpty()){
			return RdaUniversidad::where('periodo_id', null)->get();
		}
		return $rdas;
	}

	public static function getRdasPorPeriodo2($codigo_periodo){
		$rdas =  RdaUniversidad::where('periodo_id', $codigo_periodo)->get();
		return $rdas;
	}

	public static function getCurrentRdas(){
		$codigo_periodo = ActualPeriodo::getActualPeriodo()->codigo;
		return self::getRdasPorPeriodo($codigo_periodo);
	}

	public function rdas_carrera()
	{
		return $this->belongsToMany(RdaCarrera::class, 'rda_universidad_carrera', 'rda_universidad_id', 'rda_carrera_id')->withPivot('user_created');
	}
}