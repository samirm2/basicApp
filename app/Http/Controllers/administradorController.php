<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\casa;
use App\Persona;
use App\propietario;
use App\User;
use App\propietariosCasas;


class administradorController extends Controller
{
    public function index(){
    	return view('Administrador.index');
    }

    public function propietariosIndex(){
    	$casas = casa::paginate(10);
    	return view('Administrador.propietarios')->with('listadoCasas',$casas);
    }

    public function registrarPropietario(){
    	$persona = new Persona();
    	$persona->cedula = request()->cedula;
    	$persona->nombres = request()->nombres;
    	$persona->apellidos = request()->apellidos;
    	$persona->sexo = request()->sexo;
    	$persona->fecha_nacimiento = request()->birthday_submit;
    	$persona->telefono = request()->telefono;
    	$persona->email = request()->email;
    	$persona->save();

    	$usuario = new User();
    	$usuario->name = request()->usuario;
    	$usuario->password = bcrypt(request()->password);
    	$usuario->rol = request()->rol;
    	$usuario->save();

    	$propietario = new propietario();
    	$propietario->persona_id = $persona->id;
    	$propietario->save();

   		foreach (explode(",",request()->casas) as $casa) {
   			$casaPropietario = new propietariosCasas();
   			$casaPropietario->propietario_id = $propietario->id;
   			$casaPropietario->casa = casa::where('nombre',$casa)->first()->id;
   			$casaPropietario->save();
   		}

   		return back()->with('mensaje_exitoso','¡Enhorabuena! Propietario registrado con exito.');
    	
    }
}
