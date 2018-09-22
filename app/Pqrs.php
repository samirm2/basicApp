<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pqrs extends Model
{
    public function tipoPqrs(){
    	return $this->belongsTo('\App\TipoPqrs','tipo','nombre');
    }

    public function mensajes(){
    	return $this->hasMany('\App\DetallePqrs');
    }

    public function infoRemitente(){
    	return $this->belongsTo('\App\Persona','remitente');
    }

    public function infoDestinatario(){
    	return $this->belongsTo('\App\Persona','destinatario');
    }
}
