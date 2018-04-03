<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function getNombreCompletoAttribute(){
    	return $this->nombres . " " . $this->apellidos;
    }
    public function usuario(){
    	return $this->hasOne('\App\User');
    }
    public function propietario(){
    	return $this->hasOne('\App\Propietario');
    }
}
