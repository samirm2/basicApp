<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['casa_id','mes_id','valor',];

    public function casa(){
        return $this->belongsTo('\App\Casa');
    }
    public function mesPago(){
        return $this->belongsTo('\App\Mes','mes_id');
    }
}
