<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePqrs extends Model
{
    public function pqrsDatos(){
    	return $this->belongsTo('\App\Pqrs');
    }
}
