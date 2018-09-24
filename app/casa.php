<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    public function miPropietario(){
    	return $this->belongsTo('\App\Propietario','propietario_id');
    }

    public function pagos(){
        return $this->hasMany('\App\Pago');
    }

    public function getEstadoCarteraAttribute()
    {
        $pagos_pendientes  = $this->pagos->where('estado','Pendiente')->sum('saldo');
        if($pagos_pendientes <= 0){
            return false; //Al dia
        }else{
            return true; //Moroso
        }
    }

    public function getValorCuantiaAttribute()
    {
        return $this->pagos->where('estado','Pendiente')->sum('saldo');
    }
}
