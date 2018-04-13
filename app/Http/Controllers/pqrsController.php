<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pqrsController extends Controller
{
    public function guardarPqrs(){
    	$pq = new \App\Pqrs();
			$pq->asunto = request()->asunto;
			$pq->tipo = request()->tipoPqrs;

			if (request()->destinatario == null) {
  			$pq->destinatario = \App\User::where('rol','Administrador')->first()->id;
  		}else{
  			$nombreCompletoDestinatario = explode('  ', request()->destinatario);
				$destinatario =\App\Persona::where('nombres',$nombreCompletoDestinatario[0])->first();
				$pq->destinatario = $destinatario->usuario->id;
  		}

			$pq->remitente = auth()->user()->id;
			$pq->save();

			$detallePqrs = new \App\detallePqrs();
			$detallePqrs->pqrs_id = $pq->id;
			$detallePqrs->mensaje = request()->mensaje;
			$detallePqrs->autor = $pq->remitente;
			$detallePqrs->save();
			return ['bandera'=>1,'mensaje'=>'pqrs enviado exitosamente'];
    }

    public function cerrarPqrs($id){
    	$pqrs = \App\Pqrs::find((integer)$id);
    	$pqrs->estado  = 'Cerrado';
    	$pqrs->save();
    	return ['bandera'=>1,'mensaje'=>'PQRS cerrada exitosamente','a'=>$pqrs];
    }

    public function responderPqrs($id){
    	$s = new \App\detallePqrs();
			$s->pqrs_id = $id;
			$s->mensaje = request()->mensaje;
			$s->autor = auth()->user()->id;
			$s->save();
			return ['bandera'=>1,'mensaje'=>'Respuesta enviada correctamente'];
    }

    public function verMensajesPqrs($id){
    	$pqrs = \App\Pqrs::find($id);
  		return view('showPqrs',compact('pqrs'));
    }

    public function indexPropietarioPqrs(){
    	$tipoPqrs = \App\TipoPqrs::all()->pluck('nombre');
	  	$listaPqrs = \App\Pqrs::all();
	    return view('Propietario.pqrs',compact('tipoPqrs','listaPqrs'));
    }
}
