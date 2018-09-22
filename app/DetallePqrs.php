<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detallePqrs extends Model
{
    public function pqrsDatos(){
    	return $this->belongsTo('\App\Pqrs');
    }
}
