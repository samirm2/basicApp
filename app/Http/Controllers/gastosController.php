<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Gasto;
use Alert;
use Storage;
use DB;

class gastosController extends Controller
{
    public function index(){
    	$gastos = Gasto::all();
    	return view('Administrador.gastos')->with('gastos',$gastos);
    }

    public function registrarGasto(){
    	$gasto = new Gasto();
    	$gasto->concepto = request()->concepto;
    	$gasto->valor = request()->valor;
    	$gasto->observaciones = request()->observaciones;
        $gasto->evidencia = Storage::disk('public')->put('gastos', request()->file('imagen'));
    	if($gasto->save()){
          Alert::success('Gasto registrado correctamente','¡Enhorabuena!');
        }else{
          Alert::error('Ocurrio un error al guardar el gasto, intente nuevamente','¡Ups!');
        }
        return back();
    }

    public function generarRecibo(){
        date_default_timezone_set('America/Bogota');
        
        $statement = DB::select("SHOW TABLE STATUS LIKE 'gastos'");
        $nextId = $statement[0]->Auto_increment;
        
        return view('reciboPrestacionServicio')->with([
            'concepto'=>request()->concepto, 
            'valor'=>request()->valor,
            'observaciones'=>request()->observaciones,
            'id'=>$nextId
        ]);
    }
}
