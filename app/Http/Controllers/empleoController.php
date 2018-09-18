<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleo;
use App\EmpleoAspirante;
use App\Contratados;
use Alert;
use Exception;
use Storage;

class empleoController extends Controller
{
    public function empleoIndex(){
    	$datos =Empleo::all();
	    return view('Administrador.empleo')->with('arrayEmpleos',$datos);
    }
    public function trabajaIndex(){
        $datos =Empleo::all();
        return view('trabajar')->with('arrayEmpleos',$datos);
    }
    
    public function registrarNuevoEmpleo(){
    	request()->validate([
    		'cargo'=> 'required',
    		'descripcion'=> 'required',
    		'salario'=> 'required'
    	]); //se validan los campos que vienen en la peticion

    	$empleo = new Empleo();
    	$empleo->cargo = request()->cargo;
    	$empleo->descripcion = request()->descripcion;
    	$empleo->salario = request()->salario;
    	$empleo->tipo_salario = request()->tipo_salario;
    	$empleo->duracion = request()->duracion;
    	$empleo->tipo_duracion = request()->tipo_duracion;
    	$empleo->estado = request()->estado;
    	
        if($empleo->save()){
    		// return back()->with('mensaje_exitoso','¡Enhorabuena! Oferta de empleo registrada satisfactoriamente');
          Alert::success('Oferta de empleo registrada satisfactoriamente','¡Enhorabuena!');
          return back();
    	}else{
    		Alert::error('ocurrió un error al guardar el empleo');
        return back();
    	}
    }

    public function verEmpleo($id){
    	$empleo = Empleo::find($id);
	    return view('Administrador.showAspirantes')->with('empleo',$empleo);
    }

    public function eliminarEmpleo($id){
	   	$empleo = Empleo::find($id);
	   	$empleo->delete();
	   	Alert::success('Oferta de empleo eliminada correctamente','¡Enhorabuena!');
      return back();
      // return back()->with('mensaje_exitoso','¡Enhorabuena! empleo eliminado correctamente');
    }

    public function actualizarEmpleo($id){
	   	$empleo = Empleo::find($id);
	   	$empleo->cargo = request()->cargo;
	   	$empleo->descripcion = request()->descripcion;
	   	$empleo->salario = request()->salario;
	   	$empleo->estado = request()->estado;
	   	$empleo->duracion = request()->duracion;
	   	$empleo->tipo_salario = request()->tipo_salario;
	   	$empleo->tipo_duracion = request()->tipo_duracion;
	   	$empleo->save();
	   	// return back()->with('mensaje_exitoso','¡Enhorabuena! empleo actualizado correctamente');
      Alert::success('Oferta de empleo actualizada correctamente','¡Enhorabuena!');
      return back();
    }

    public function registrarPostulante(){
        try {
            $aspirante = new EmpleoAspirante();
            $aspirante->cc = request()->cc;
            $aspirante->nombres = request()->nombres;
            $aspirante->apellidos = request()->apellidos;
            $aspirante->email = request()->email;
            $nombreArchivo = request()->cc."_".request()->nombres."_".$aspirante->apellidos.".".request()->archivo->extension();
            $aspirante->hoja_vida = request()->archivo->storeAs('public/hojas_de_vida',$nombreArchivo);
            $aspirante->empleo_id = request()->empleo;
            
            if($aspirante->save()){
                Alert::success("Te has postulado correctamente ,¡Suerte!","¡Felicidades!");
            return back();
            }else{
                Alert::error('Ocurrió un error al realizar la postulación','Opps!');
            return back();
            }
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Ya está registrada la cédula en los registros','Opps!')->autoclose(3000);
                return back();
            }
        }
    }

    public function download($file_name){
        $file = 'public/hojas_de_vida/'.$file_name;
        $disk = Storage::disk('local');
        if ($disk->exists($file)) {
            $fs = Storage::disk('local')->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    public function contratar($id_aspirante){
        date_default_timezone_set('America/Bogota');
        
        $aspirante = new EmpleoAspirante();
        $contratado = new Contratados();

        $aspirante_ = $aspirante->find($id_aspirante)->first();

        $contratado->cc = $aspirante_['cc'];
        $contratado->nombres = $aspirante_['nombres'];
        $contratado->apellidos = $aspirante_['cc'];
        $contratado->email = $aspirante_['email'];
        $contratado->hoja_vida = $aspirante_['hoja_vida'];
        $contratado->empleo_id = $aspirante_['empleo_id'];
        $contratado->fecha_inicio = date('Y-m-d');

        $aspirante_->delete();

        if ($contratado->save()) {
            Alert::success("Registrado correctamente","¡Felicidades!");
            return back();
        } else {
            Alert::error('Ocurrió un error al realizar el registro','Opps!');
            return back();
        }
    }
}
