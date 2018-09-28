<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialArrendatarios extends Model
{
    public function personaDatos(){
    	return $this->belongsTo('\App\Persona', 'persona_id');
    }

    public function casaDatos(){
    	return $this->belongsTo('\App\casa', 'casa_id');
    }
}