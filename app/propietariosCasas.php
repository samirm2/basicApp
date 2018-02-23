<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class propietariosCasas extends Model
{
    public function datosPropietario(){
    	return $this->belongsTo('\App\propietario','propietario_id');
    }

    public function datosCasa(){
    	return $this->belongsTo('\App\casa','casa');
    }
}
