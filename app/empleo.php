<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    public function aspirantes(){
    	return $this->hasMany('\App\EmpleoAspirante');
    }

    public function contratados(){
    	return $this->hasMany('\App\Contrataods');
    }
}
