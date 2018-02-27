<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Gasto;

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
    	$gasto->save();
    	return back()->with('mensaje_exitoso','¡Enhorabuena! Gasto registrado satisfactoriamente.');
    }
}
