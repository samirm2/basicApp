
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
		Route::get('Gastos/Recibo', 'gastosController@generarRecibo');
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

		Route::get('Cartera', function () {
			$casasPaginate = \App\Casa::paginate(10);
			$casas = \App\Casa::all();
			$totalCartera = 0;
			foreach($casas as $casa){
				$totalCartera += $casa->valorCuantia;
			}			
		    return view('Administrador.cartera',compact('casasPaginate','totalCartera'));
		});

		Route::get('Contratos/Activos', 'contratoController@activos');
		Route::get('Contratos/Historial', 'contratoController@historial');
		Route::get('Contratos/Finalizar/{id}', 'contratoController@finalizarContrato');		

		Route::get('Empleo', 'empleoController@empleoIndex');
		Route::post('Empleo','empleoController@registrarNuevoEmpleo')->name('empleo.guardar');
		Route::get('Empleo/{id}', 'empleoController@verEmpleo');
		Route::get('Empleo/Download/{file_name}', 'empleoController@download');
		Route::get('Empleo/Contratar/{id_aspirante}', 'empleoController@contratar');
		Route::put('Empleo/{id}','empleoController@actualizarEmpleo')->name('empleo.actualizar');

		Route::delete('Empleo/{id}','empleoController@eliminarEmpleo')->name('empleo.eliminar');
		
		Route::resource('Backup','backupContoller');
		Route::get('Backup/download/{file_name}', 'backupContoller@download');
		Route::get('Backup/delete/{file_name}', 'backupContoller@delete');
		Route::get('Backup/restore/{file_name}', 'backupContoller@restore');
		
		Route::get('Reportes', function(){
			$meses = \App\Mes::all();
			return view('Administrador.Reportes',compact('meses'));
		});

		Route::get('Reportes/balance-casas/{mes}', function($mes){
			if($mes == 'null'){
				$mes = Carbon\Carbon::now()->month;
			}
			
			$nombreMes  = \App\Mes::find($mes)->nombre;
			$pagosMes = App\Pago::where('mes_id',$mes)->get();
			$casaAlDia = $pagosMes->where('estado','Pagado')->count();
			$casaPendiente = $pagosMes->where('estado','Pendiente')->count();
			$casas = \App\Casa::all();
			if($pagosMes->count() == 0){
				return 'No Existen Datos Para Realizar este Reporte';
			}else{
				$pdf = PDF::loadView('reportes.balanceCasas',compact('mes','nombreMes','casas','casaAlDia','casaPendiente'));
				$pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
				return $pdf->stream('Balance Mes.pdf');
			}
			
			
			//	return view('reportes.balanceCasas',compact('nombreMes','casas','casaAlDia','casaPendiente'));
		})->name('reportes.balanceMes');
				
		Route::get('reportes/pazysalvo/{casaId}', function($casaId){
			$casa = \App\Casa::find($casaId);
			$hoy = Carbon\Carbon::now();
			$mes = \App\Mes::find($hoy->month)->nombre;
			if($casa->estadoCartera){
				return 'Error! Esta Casa No Esta Al Dia';
			}else{
				$pdf = PDF::loadView('reportes.paz_y_salvo',compact('casa','hoy','mes'));
				$pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>true]);
				return $pdf->stream('paz_y_salvo.pdf');
			}
			// return view('reportes.paz_y_salvo', compact('casa','hoy','mes'));
		})->name('reportes.pazysalvo');

		Route::get('reportes/cartera', function(){
			$casas = \App\Casa::all();
			$hoy = Carbon\Carbon::now();
			$nombreArchivo = 'Cartera'.$hoy->year.'-'.$hoy->month.'-'.$hoy->day.'.pdf';
			$pdf = PDF::loadView('reportes.imprimirCartera',compact('casas'));
			$pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isRemoteEnabled'=>false]);
			return $pdf->stream($nombreArchivo);
		
			// return view('reportes.paz_y_salvo', compact('casa','hoy','mes'));
		})->name('reportes.imprimirCartera');
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