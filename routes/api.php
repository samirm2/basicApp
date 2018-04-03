<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/casas', function () {
    $casas = \App\Casa::pluck('nombre');
    $array = [];
    foreach ($casas as $casa) {
    	$array += ["$casa" => null];
    }
    return $array;
    // return \App\Casa::pluck('nombre');
})->name('api.casas');

Route::get('/personas',function(){
	$busqueda = \App\Persona::all()->pluck('NombreCompleto');
	$rta = ['bandera'=>0];
	if ($busqueda->count() < 1) {
		return $rta;
	}else{
		$rta['bandera'] = 1;
	 	$rta['contactos'] = $busqueda;
		return $rta;
	}
})->name('api.personas');

Route::get('/personas/{cedula}',function($cedula){
	$busqueda = \App\Persona::where('cedula',$cedula)->first();

	if ($busqueda == "") {
		return ["bandera"=>0];
	}else{
		return [
			"bandera"=>1,
			"persona"=>$busqueda,
			"usuario"=>$busqueda->usuario,
			"casas"  =>$busqueda->propietario->misCasas
		];
	}
});
