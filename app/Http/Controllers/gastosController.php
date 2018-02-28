<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Gasto;
use Alert;

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
    	$gasto->evidencia = request()->file('imagen')->store('public/gastos');
    	if($gasto->save()){
            Alert::success('Gasto registrado correctamente','¡Enhorabuena!');
        }else{
            Alert::error('Ocurrio un error al guardar el gasto, intente nuevamente','¡Ups!');
        }
        return back();
    }
}
