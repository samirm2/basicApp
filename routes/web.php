
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

Route::get('/','Auth\LoginController@index')->name('login')->middleware('guest');
Route::post('/login','Auth\LoginController@login')->name('login.enter');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/trabaja-con-nosotros', 'empleoController@trabajaIndex');
Route::post('/postularme', 'empleoController@registrarPostulante');

Route::get('/pdf', function () {
    $pago = \App\Pago::find(724);
	$pdf = PDF::loadHtml('<h1>hola</h1>');
	$pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
	//return view('reportes.listadoPropietarios',compact('casas'));
	return $pdf->stream('recib.pdf');
});

//rutas para todos
Route::post('pqrs','pqrsController@guardarPqrs')->name("pqrs.guardar")->middleware('auth');
Route::post('pqrs/{id}','pqrsController@cerrarPqrs')->name("pqrs.cerrar")->middleware('auth');

//Rutas del Admin
Route::group(['middleware'=>['auth','administrador']],function(){
	Route::prefix('Administrador')->group(function(){
		Route::get('/', 'administradorController@index');
		
		Route::get('Propietarios', 'administradorController@propietariosIndex');
		Route::get('listaPropietarios', 'administradorController@reportePropietarios')->name('reportesProp');
		Route::post('Propietarios', 'administradorController@registrarPropietario')->name('propietario.guardar');
		Route::put('Propietarios/{id}', 'administradorController@actualizarPropietario')->name('propietario.actualizar');

		Route::post('Casas/Liberar/{casaId}','casaController@liberar')->name('liberar.casa');

		Route::get('Gastos', 'gastosController@index');
		Route::post('Gastos','gastosController@registrarGasto')->name('gasto.registrar');
		
		Route::get('pqrs/salida',function(){
			$tipoPqrs = \App\TipoPqrs::all()->pluck('nombre');
		  $listaPqrs = \App\Pqrs::all();
		  $bandeja = 'salida';
			return view('Administrador.pqrs',compact('tipoPqrs','listaPqrs','bandeja'));
		});

		Route::get('pqrs/entrada',function(){
			$tipoPqrs = \App\TipoPqrs::all()->pluck('nombre');
		  $listaPqrs = \App\Pqrs::all();
		  $bandeja = 'entrada';
			return view('Administrador.pqrs',compact('tipoPqrs','listaPqrs','bandeja'));
		});
		Route::get('pqrs/{id}', 'pqrsController@verMensajesPqrs');
		Route::post('pqrs/{id}','pqrsController@responderPqrs');
			
		Route::get('Pagos', function () {
			$pagos = \App\Pago::orderBy('id','desc')->paginate(10);
			$meses = \App\Mes::all();
			$mesActual = Carbon\Carbon::now()->month;
		    return view('Administrador.pagos',compact('pagos','meses','mesActual'));
		});
		Route::get('Pagos/{facturaId}', 'pagosController@showPago')->name('pagos.examinar');
		Route::get('Pagos/generar/{mes}', 'pagosController@generarRecibos')->name('pagos.generar');
		Route::post('Pagos', 'pagosController@realizarPago')->name('pagos.pagar');

		Route::get('Empleo', 'empleoController@empleoIndex');
		Route::post('Empleo','empleoController@registrarNuevoEmpleo')->name('empleo.guardar');
		Route::get('Empleo/{id}', 'empleoController@verEmpleo');
		Route::put('Empleo/{id}','empleoController@actualizarEmpleo')->name('empleo.actualizar');
		Route::delete('Empleo/{id}','empleoController@eliminarEmpleo')->name('empleo.eliminar');	

		Route::resource('Backup','backupContoller');
		Route::get('Backup/download/{file_name}', 'backupContoller@download');
        Route::get('Backup/delete/{file_name}', 'backupContoller@delete');
	});
});

//Rutas de Propietarios
Route::group(['middleware'=>['auth','propietario']],function(){
	Route::prefix('Propietario')->group(function(){
		Route::get('/','propietarioController@index');
		Route::get('/casas','propietarioController@misCasasForm');

		Route::get('pqrs', 'pqrsController@indexPropietarioPqrs');
		Route::get('pqrs/{id}', 'pqrsController@verMensajesPqrs')->middleware('pqrs');
		Route::post('pqrs/{id}','pqrsController@responderPqrs');
		

		Route::get('/pagos', function () {
			$casas = Auth::user()->persona->propietario->misCasas;
			$pagos = [];
			$meses = \App\Mes::all();
			foreach ($casas as $casa) {
				foreach ($casa->pagos as $pago) {
					$pagos[] = $pago;
				}
			}
		    return view('Propietario.misPagos',compact('pagos','meses','casas'));
		});

		Route::get('/Pagos/{id}', function ($id) {
			$pago = \App\Pago::find($id);
		    return view('showReciboPago')->with('pago',$pago);
		});

	});
});

//Rutas de Arrendatarios
Route::group(['middleware'=>['auth','arrendatario']],function(){
	Route::get('/Arrendatario', function () {
	    return view('Arrendatario.index');
	});
});

Route::get('/Celador', function () {
    return view('Celador.index');
});