<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empleo extends Model
{
    public function aspirantes(){
    	return $this->hasMany('\App\EmpleoAspirante','id_empleo');
    }
}
