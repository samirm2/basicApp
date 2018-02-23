<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class propietario extends Model
{
    public function misCasas(){
    	return $this->hasMany('\App\propietariosCasas','propietario_id');
    }

    public function persona(){
    	return $this->belongsTo('\App\Persona');
    }
}
