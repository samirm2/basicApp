<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\User;
use App\Arrendatarios;
use App\HistorialArrendatarios;
use Alert;

class propietarioController extends Controller
{
	public function __construct(){
	    $this->middleware('auth');
	}

	public function index(){
		return view('Propietario.index');
	}

	public function misCasasForm(){
		$listaCasas = auth()->user()->persona->propietario->misCasas;
		foreach ($listaCasas as $key => $value) {
			$arrendatario = Arrendatarios::where('casa_id', $value['id'])->first();
			if ($arrendatario != null) {
				$listaCasas[$key]['arrendatario'] = $arrendatario->personaDatos()->first();
			}
		}

		return view('Propietario.misCasas', compact('listaCasas'));
	}

	public function guardarArrendatario($id){
		$persona = new Persona();
		$persona->cedula = request()->cedula;
		$persona->nombres = request()->nombres;
		$persona->apellidos = request()->apellidos;
		$persona->sexo = request()->sexo;
		$persona->fecha_nacimiento = request()->fecha_nacimiento;
		$persona->telefono = request()->telefono;
		$persona->email = request()->email;
		$persona->save();

		$usuario = new User();
      	$usuario->name = strtolower(request()->usuario);
      	$usuario->password = bcrypt(request()->password);
      	$usuario->rol = 'Arrendatario';
      	$usuario->persona_id = $persona->id;
      	$usuario->save();

      	$arrendatario = new Arrendatarios();
      	$arrendatario->persona_id = $persona->id;
      	$arrendatario->casa_id = $id;
      	$arrendatario->save();

      	Alert::success('Registrado correctamente','¡Enhorabuena!');
      	return back();
	}

	public function liberarCasa($id){
		date_default_timezone_set('America/Bogota');
		$arriendo = Arrendatarios::where('casa_id', $id)->first();
		
		$historial = new HistorialArrendatarios();
		$historial->persona_id = $arriendo->persona_id;
		$historial->casa_id = $arriendo->casa_id;
		$historial->fecha_inicio = $arriendo->created_at->format('Y-m-d');
		$historial->fecha_fin = date('Y-m-d');

		$user = User::where('persona_id', $arriendo->persona_id)->first();
		$user->password = bcrypt('ya.no.puedes.entrar');
		$user->save();

		$historial->save();
		$arriendo->delete();

		Alert::success('Liberada correctamente','¡Enhorabuena!');
      	return back();
	}
}
