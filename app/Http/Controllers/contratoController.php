<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleo;
use App\Contratados;
use Alert;

class contratoController extends Controller
{
    public function activos(){
    	$empleos_contratados = [];
    	$empleos = Empleo::all();
    	
    	foreach ($empleos as $key => $value) {
    		$empleos[$key]['contratados'] = [];
    		$temp = $value->contratados()->where('fecha_terminacion', null)->get();
    		if (count($temp) > 0) {
    			$empleos[$key]['contratados'] = $temp;
    			array_push($empleos_contratados, $empleos[$key]);
    		}
    	}

    	return view('Administrador.contratosActivos')->with('arrayEmpleos', $empleos_contratados);
    }

    public function historial(){
    	$empleos_historial = [];
    	$empleos = Empleo::all();
    	
    	foreach ($empleos as $key => $value) {
    		$empleos[$key]['contratados'] = [];
    		$temp = $value->contratados()->where('fecha_terminacion', '<>', null)->get();
    		if (count($temp) > 0) {
    			$empleos[$key]['contratados'] = $temp;
    			array_push($empleos_historial, $empleos[$key]);
    		}
    	}

    	return view('Administrador.contratosHistorial')->with('arrayEmpleos', $empleos_historial);
    }

    public function finalizarContrato($id){
    	date_default_timezone_set('America/Bogota');

    	$contrato = Contratados::find($id);

    	$contrato->fecha_terminacion = date('Y-m-d');

    	if ($contrato->save()) {
    		Alert::success('Contrato finalizado satisfactoriamente','¡Enhorabuena!')->autoclose(3000);
          	return back();
    	}else{
    		Alert::error('ocurrió un error');
        	return back();
    	}
    	
    }
}
