<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class casa extends Model
{
    public function miPropietario(){
    	return $this->hasOne('\App\propietariosCasas','casa');
    }
}
