<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Casa;
use App\Persona;
use App\propietario;
use App\User;
use Alert;

class administradorController extends Controller
{
    public function index(){
    	return view('Administrador.index');
    }

    public function propietariosIndex(){
    	$casas = Casa::paginate(10);
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
    	$usuario->persona_id = $persona->id;
    	$usuario->save();

    	$propietario = new Propietario();
    	$propietario->persona_id = $persona->id;
    	$propietario->save();

   		foreach (explode(",",request()->casas) as $casa) {
   			$casaPropietario = Casa::where('nombre',$casa)->first();
   			$casaPropietario->propietario_id = $propietario->id;
   			$casaPropietario->save();
   		}

      Alert::success('Propietario registrado con exito.',"¡Enhorabuena!");
   		return back();
    }

    public function actualizarPropietario($id){
      $persona = Persona::find($id);
    	$persona->cedula = request()->cedula;
    	$persona->nombres = request()->nombres;
    	$persona->apellidos = request()->apellidos;
    	$persona->sexo = request()->sexo;
    	
      if (!is_null(request()->birthday_submit)) {
    		$persona->fecha_nacimiento = request()->birthday_submit;
    	}
    	
    	$persona->telefono = request()->telefono;
    	$persona->email = request()->email;
    	$persona->save();
    	
    	$usuarioPersona = $persona->usuario;
    	$usuarioPersona->name = request()->usuario;

    	if (!is_null(request()->password)) {
    		$usuarioPersona->password = bcrypt(request()->password);
    	}

    	$usuarioPersona->save();

    	Alert::success('El propietario '.$persona->nombres." ".$persona->apellidos .' fue actualizado con exito.',"¡Enhorabuena!");
      return back();
    }

    
}
