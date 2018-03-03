<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    public function miPropietario(){
    	return $this->belongsTo('\App\Propietario','propietario_id');
    }
}
