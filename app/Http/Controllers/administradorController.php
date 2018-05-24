<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Casa;
use App\Persona;
use App\propietario;
use App\User;
use Alert;
use PDF;
class administradorController extends Controller
{
  public function index(){
  	return view('Administrador.index');
  }

  public function propietariosIndex(){
  	$casas = Casa::paginate(10);
  	return view('Administrador.propietarios')->with('listadoCasas',$casas);
  }

  public function reportePropietarios(){
    $casas = \App\Casa::all();
    $pdf = PDF::loadView('reportes.listadoPropietarios',['casas'=>$casas])->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
    return $pdf->stream('recib.pdf');
    //return view('reportes.listadoPropietarios',compact('casas'));
  }

  public function registrarPropietario(){
  	$validacion = request()->validate([
          "cedula"    => 'required|unique:personas,cedula',
          "nombres"   => 'required',
          "apellidos" => 'required',
          "birthday"  => 'nullable',
          "telefono"  => 'required|numeric',
          "email"     => 'required|email|unique:personas,email',
          "usuario"   => 'required|unique:users,name',
          "password"  => 'required|confirmed',
          "casas"     => 'required'
      ],[
          "cedula.unique" => "La cedula ingresada ya existe en el sistema",
          "usuario.unique" => "El usuario ingresado ya existe en el sistema",
          "email.unique" => "El correo electronico ingresado ya existe en el sistema",
          "password.confirmed" => "Las contraseñas no coinciden"
      ]);

    $arrayRta = ["bandera"=>1,"mensaje"=>"","casas"=>[]];
    $contadorCasa = 0;
    $casasArray= explode(",",request()->casas);
    
    foreach ($casasArray as $casa) {
      $casaPropietario = Casa::where('nombre',$casa)->first();
      if (!is_null($casaPropietario->propietario_id)) {
        #esta casa ya tiene un propietario asignado
        $contadorCasa += 1;
        $arrayRta['casas'][] = 'la '.$casaPropietario->nombre. ' ya esta asociada a otro propietario';
      }
    }

    if ($contadorCasa == count($casasArray)) {
      $arrayRta['bandera'] = 1;
      $arrayRta['mensaje'] = 'No se pudo registrar el propietario';
      return $arrayRta;
    }else{
      $persona = new Persona();
      $persona->cedula = request()->cedula;
      $persona->nombres = request()->nombres;
      $persona->apellidos = request()->apellidos;
      $persona->sexo = request()->sexo;
      $persona->fecha_nacimiento = request()->birthday;
      $persona->telefono = request()->telefono;
      $persona->email = request()->email;
      $persona->save();

      $usuario = new User();
      $usuario->name = strtolower(request()->usuario);
      $usuario->password = bcrypt(request()->password);
      $usuario->rol = request()->rol;
      $usuario->persona_id = $persona->id;
      $usuario->save();

      $propietario = new Propietario();
      $propietario->persona_id = $persona->id;
      $propietario->save();  

      foreach ($casasArray as $casa) {
        $casaPropietario = Casa::where('nombre',$casa)->first();
        if (is_null($casaPropietario->propietario_id)) {
          $casaPropietario->propietario_id = $propietario->id;
          $casaPropietario->save(); 
        }
      }
      $arrayRta['bandera'] = 0;
      $arrayRta['mensaje'] = "Propietario registrado correctamente";
      // Alert::success('Propietario registrado con exito.',"¡Enhorabuena!");
      // return back();
      return $arrayRta;
    }
  }

  public function actualizarPropietario($id){
    $validacion = request()->validate([
          "nombres"   => 'required',
          "apellidos" => 'required',
          "birthday"  => 'nullable',
          "telefono"  => 'required|numeric',
          "email"     => 'required|email',
          "usuario"   => 'required|',
          "password"  => 'nullable|confirmed',
          "casas"     => 'required'
      ],[
          "password.confirmed" => "Las contraseñas no coinciden"
      ]);
    $arrayRta = ['bandera'=>0, 'mensaje'=>'', 'casas'=>[]];
    $casasArray= explode(",",request()->casas);
    $persona = Persona::find($id);

    foreach ($casasArray as $casa) {
      $casaPropietario = Casa::where('nombre',$casa)->first();
      if (!is_null($casaPropietario->miPropietario)) {
        if ($casaPropietario->miPropietario->persona->cedula != $persona->cedula) {
          #esta casa ya tiene un propietario asignado y no es el mismo
          $arrayRta['bandera'] = 1;
          $arrayRta['casas'][] = 'la '.$casaPropietario->nombre. ' ya esta asociada a otro propietario';
        }  
      }
    }
    if (count($arrayRta['casas']) > 0) {
      $arrayRta['mensaje'] = "Ocurrio un error al actualizar propietario";
      return $arrayRta;
    }else{
      if (Persona::where('email',request()->email)->first()->cedula != $persona->cedula) {
        #el email ya existe en el sistema
        return ['bandera'=>1, 'mensaje'=>'El correo electronico ya existe en el sistema'];
      }else{
        $usuario= User::where('name',request()->usuario)->first();
        if (is_null($usuario)) {
          return $this->propiUpdate($persona, request(), $casasArray);
        }else{
          if ($usuario->persona->cedula != $persona->cedula) {
            return ['bandera'=>1, 'mensaje'=>'El usuario ya existe en el sistema'];
          }else{
            return $this->propiUpdate($persona, request(), $casasArray);
          }  
        }
      }
    }
  }

  private function propiUpdate($persona, $peticion,$casasArray){
    
    $persona->nombres = $peticion->nombres;
    $persona->apellidos = $peticion->apellidos;
    $persona->sexo = $peticion->sexo;
    $persona->fecha_nacimiento = $peticion->birthday;
    $persona->telefono = $peticion->telefono;
    $persona->email = $peticion->email;
    $persona->save();

    $persona->usuario->name = $peticion->usuario;
    if (!is_null($peticion->password)) {
      $persona->usuario->password = bcrypt($peticion->password);
    }
    $persona->usuario->save();

    foreach ($casasArray as $casa) {
      $casaPropietario = Casa::where('nombre',$casa)->first();
      if (is_null($casaPropietario->miPropietario)) {
        $casaPropietario->propietario_id = $persona->propietario->id;
        $casaPropietario->save();
      }
    }

    return ['bandera'=>0, 'mensaje'=>'El propietario '.$persona->nombres." ".$persona->apellidos .' fue actualizado con exito.'];
  }
}
