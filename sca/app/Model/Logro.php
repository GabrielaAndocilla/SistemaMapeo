<?php

namespace Udla\Model;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    protected $table = "rda_uni_carrera_logro";
	
	public function rdaUniversidad(){
		return $this->belongsTo(RdaUniversidad::class,'rda_uni_id','id');
	}
	
	public function carrera(){
		return $this->belongsTo(Career::class,'carrera_codigo','codigo');
	}
}
