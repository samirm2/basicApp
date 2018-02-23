<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleoAspirante extends Model
{
	public function empleo(){
    	return $this->belongsTo('\App\empleo','id_empleo');
    }
}
