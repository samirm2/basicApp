<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\empleo;
use App\EmpleoAspirante;

class empleoController extends Controller
{
    public function registrarNuevaOferta(){
    	request()->validate([
    		'cargo'=> 'required',
    		'descripcion'=> 'required',
    		'salario'=> 'required'
    	]);
    	$empleo = new empleo();
    	$empleo->cargo = request()->cargo;
    	$empleo->descripcion = request()->descripcion;
    	$empleo->salario = request()->salario;
    	$empleo->tipo_salario = request()->tipo_salario;
    	$empleo->duracion = request()->duracion;
    	$empleo->tipo_duracion = request()->tipo_duracion;
    	$empleo->estado = request()->estado;
    	if($empleo->save()){
    		return back()->with('mensaje_exitoso','¡Enhorabuena! Oferta de empleo registrada satisfactoriamente');
    	}else{
    		return 'ocurrion un error al guardar el emplo';
    	}
    }

    public function eliminarEmpleo($id){
	   	$empleo = empleo::find($id);
	   	$empleo->delete();
	   	return back()->with('mensaje_exitoso','¡Enhorabuena! empleo eliminado correctamente');
    }

    public function registrarPostulante(){
    	$aspirante = new EmpleoAspirante();
    	$aspirante->nombres = request()->nombres;
    	$aspirante->apellidos = request()->apellidos;
    	$aspirante->email = request()->email;
    	$nombreArchivo = request()->nombres."_".$aspirante->apellidos.".".request()->archivo->extension();
    	$aspirante->hoja_vida = request()->archivo->storeAs('public/hojas_de_vida',$nombreArchivo);
    	$aspirante->id_empleo = request()->empleo;
    	
    	if($aspirante->save()){
    		return back()->with('mensaje_exitoso','¡Enhorabuena! te has postulado exitosamente');
    	}else{
    		return "error";
    	}

    }
}
