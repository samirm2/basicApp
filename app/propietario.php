<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    public function misCasas(){
    	return $this->hasMany('\App\Casa');
    }

    public function persona(){
    	return $this->belongsTo('\App\Persona');
    }
}
