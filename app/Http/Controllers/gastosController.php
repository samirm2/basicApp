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
        
        if (request()->tipo_gasto == 'Cotidiano') {
            $gasto->evidencia = Storage::disk('public')->put('gastos', request()->file('imagen'));
        } else {
            $img = str_replace('data:image/png;base64,', '', request()->imagen_generada);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = '../public/uploads/gastos/'. uniqid() . '.png';
            file_put_contents($file, $data);

            $gasto->evidencia = explode('uploads/', $file)[1];
        }

    	if($gasto->save()){
          Alert::success('Gasto registrado correctamente','¡Enhorabuena!');
        }else{
          Alert::error('Ocurrio un error al guardar el gasto, intente nuevamente','¡Ups!');
        }
        return back();
    }

    public function generarRecibo(){
        date_default_timezone_set('America/Bogota');

        $image = file_get_contents("http://barcode.tec-it.com/barcode.ashx?data=".date('Ymd')."-".date('His')."&code=Code128&dpi=75");
        file_put_contents('../public/uploads/gastos/code.png', $image);
                
        return view('reciboPrestacionServicio')->with([
            'concepto'=>request()->concepto, 
            'valor'=>request()->valor,
            'observaciones'=>request()->observaciones
        ]);
    }
}
