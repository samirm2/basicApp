<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $table = 'meses';

    public function pagos(){
        return $this->hasMany('App\Pago');
    }
}
