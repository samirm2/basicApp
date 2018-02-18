
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
Route::get('/trabaja-con-nosotros', function () {
    $datos =\App\empleo::all();
    return view('trabajar')->with('arrayEmpleos',$datos);
});
Route::post('/postularme', 'empleoController@registrarPostulante');

Route::get('/pdf', function () {
 //    $pdf = PDF::loadHtml('<h1>Hello World</h1><img src="http://barcode.tec-it.com/barcode.ashx?data=123456&code=Code128&dpi=75">');
	// return $pdf->stream('recib.pdf');
	// return dd(\App\empleo::find(1)->aspirantes->count());
	return Storage::url('hojas_de_vida/pedro_navajas.pdf');
});

Route::prefix('Administrador')->group(function(){
	Route::get('/', function () {
    	return view('Administrador.index');
	});
	Route::get('Propietarios', function () {
   		return view('Administrador.propietarios');
	});
	Route::get('pqrs', function () {
	    return view('Administrador.pqrs');
	});
	Route::get('pqrs/{id}', function ($id) {
	    $datos = ['pqrs'=>$id, 'mensaje'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat.',"asunto"=>'La señora no limpia su frente',"tipo"=>'Queja',"estado"=>"Cerrado"];
	    return view('showPqrs')->with('datos',$datos);
	});
	Route::get('Gastos', function () {
	    return view('Administrador.gastos');
	});
	Route::get('Pagos', function () {
	    return view('Administrador.pagos');
	});
	Route::get('Empleo', function () {
		$datos =\App\empleo::all();
	    return view('Administrador.empleo')->with('arrayEmpleos',$datos);
	});
	Route::post('Empleo','empleoController@registrarNuevaOferta')->name('empleo.guardar');
	
	Route::get('Empleo/{id}', function ($id) {
		$empleo = \App\empleo::find($id);
	    return view('Administrador.showAspirantes')->with('empleo',$empleo);
	});
});


Route::get('/Propietario', function () {
    return view('Propietario.index');
});
Route::get('/Propietario/pqrs', function () {
    return view('Propietario.pqrs');
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