
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/trabaja-con-nosotros', 'empleoController@trabajaIndex');

Route::post('/postularme', 'empleoController@registrarPostulante');

Route::get('/pdf', function () {
    $pdf = PDF::loadHtml('<h1>Hello World</h1><img src="http://barcode.tec-it.com/barcode.ashx?data=123456&code=Code128&dpi=75">');
	return $pdf->stream('recib.pdf');
	// Alert::success('te has postulado exitosamente','¡Enhorabuena!');//->autoclose(false);
	// return redirect('/');
});

Route::prefix('Administrador')->group(function(){
	Route::get('/', 'administradorController@index');
	
	Route::get('Propietarios', 'administradorController@propietariosIndex');
	Route::post('Propietarios', 'administradorController@registrarPropietario')->name('propietario.guardar');
	Route::put('Propietarios/{id}', 'administradorController@actualizarPropietario')->name('propietario.actualizar');

	Route::post('Casas/Liberar/{casaId}','casaController@liberar')->name('liberar.casa');

	Route::get('pqrs', function () {
	    $listaPqrs = \App\TipoPqrs::all()->pluck('nombre');
	    return view('Administrador.pqrs',compact('listaPqrs'));
	});

	Route::post('pqrs', function () {
	    return ['recibo en el controlador tu peticion'];
	})->name("pqrs.guardar");

	Route::get('pqrs/{id}', function ($id) {
	    $datos = ['pqrs'=>$id, 'mensaje'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat.',"asunto"=>'La señora no limpia su frente',"tipo"=>'Queja',"estado"=>"Cerrado"];
	    return view('showPqrs')->with('datos',$datos);
	});
	
	Route::get('Gastos', 'gastosController@index');
	Route::post('Gastos','gastosController@registrarGasto')->name('gasto.registrar');
	
	Route::get('Pagos', function () {
	    return view('Administrador.pagos');
	});

	Route::get('Empleo', 'empleoController@empleoIndex');
	Route::post('Empleo','empleoController@registrarNuevoEmpleo')->name('empleo.guardar');
	Route::get('Empleo/{id}', 'empleoController@verEmpleo');
	Route::put('Empleo/{id}','empleoController@actualizarEmpleo')->name('empleo.actualizar');
	Route::delete('Empleo/{id}','empleoController@eliminarEmpleo')->name('empleo.eliminar');	
});

Route::get('/Propietario', function () {
    return view('Propietario.index');
});
Route::get('/Propietario/pqrs', function () {
    $listaPqrs = \App\TipoPqrs::all()->pluck('nombre');
    return view('Propietario.pqrs',compact('listaPqrs'));
});
Route::get('/Propietario/pqrs/{id}', function ($id) {
    $datos = ['pqrs'=>$id, 'texto'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'];
	return view('showPqrs')->with('datos',$datos);
});
Route::get('/Propietario/casas', function () {
    return view('Propietario.misCasas');
});
Route::get('/Propietario/pagos', function () {
    return view('Propietario.misPagos');
});
Route::get('/Propietario/pagos/{id}', function ($id) {
    return view('Propietario.showReciboPago')->with('pago',$id);
});

Route::get('/Arrendatario', function () {
    return view('Arrendatario.index');
});

Route::get('/Celador', function () {
    return view('Celador.index');
});