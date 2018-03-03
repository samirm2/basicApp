<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    public function aspirantes(){
    	return $this->hasMany('\App\EmpleoAspirante');
    }
}
