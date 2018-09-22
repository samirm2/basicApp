<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPqrs extends Model
{
    public function pqrs(){
    	return $this->hasMany('\App\Pqrs','tipo','nombre');
    }
}
