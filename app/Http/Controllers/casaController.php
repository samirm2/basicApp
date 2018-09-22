<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Casa;
use App\Propietario;
use Alert;

class casaController extends Controller
{
    public function liberar($casaId){
    	$casa = Casa::find($casaId);
    	$propietario = $casa->propietario_id;
    	$nCasas = Casa::where('propietario_id',$propietario)->get()->count();
    	$casa->propietario_id = null;
    	$casa->save();
    	if ($nCasas < 2) {
    		Propietario::find($propietario)->persona->delete();
    	}
    	    	
    	Alert::success("Casa liberada satisfactoriamente","Excelente");
    	return back();
    }
}
