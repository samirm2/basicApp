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


Route::get('/pagos/{id}', function($id) {
	$pago = App\Pago::find($id);
	if(is_null($pago)){
		return ['pago'=>null];
	}else{
		$casaNombre = $pago->casa;
		return ['pago' => $pago, 'casa' => $casaNombre];
	}	
})->name('pagos.buscar');


Route::get('casa/pagos', function() {
	$pagos = \App\Casa::find(request()->casa)->pagos;
	foreach($pagos as $pago){
		$pago['mes']=$pago->mesPago->nombre;
		$pago->valor = number_format($pago->valor);
	}
	return $pagos;
})->name('api.pagos.casas');


Route::get('charts/pie', function() {
	$hoy = Carbon\Carbon::now();
	$mesActual = $hoy->month;
	$anoActual = $hoy->year;
	$nombreMes = App\Mes::find($mesActual)->nombre;
	$pagosActual = App\Pago::where('mes_id',$mesActual)->whereYear('created_at',$anoActual)->get();
	$pagosPendientes = $pagosActual->where('estado','Pendiente')->count();
	$pagosPagados = $pagosActual->where('estado','Pagado')->count();
	return [
		'año'=>$anoActual,
		'mes'=> $nombreMes,
		'casasAlDia'=> $pagosPagados, 
		'casasMorosas'=> $pagosPendientes
	];
})->name('api.chart.pie');

Route::get('charts/consulta/pies', function() {
	
	$mesId = request()->mes;
	$ano = request()->ano;
	$nombreMes = App\Mes::find($mesId)->nombre;
	$pagosConsulta = App\Pago::where('mes_id',$mesId)->whereYear('created_at',$ano)->get();
	$pagosPendientes = $pagosConsulta->where('estado','Pendiente')->count();
	$pagosPagados = $pagosConsulta->where('estado','Pagado')->count();
	return [
		'año'=>$ano,
		'mes'=> $nombreMes,
		'casasAlDia'=> $pagosPagados, 
		'casasMorosas'=> $pagosPendientes
	];
})->name('api.chart.pie.consulta');

Route::get('charts/barras', function() {
	$hoy = Carbon\Carbon::now();
	$mes = \App\Mes::find($hoy->month);
	$gastos = \App\Gasto::whereMonth('created_at',$hoy->month)->whereYear('created_at',$hoy->year)->get();
	$pagos  = \App\Pago::where('estado','Pagado')->whereMonth('created_at',$hoy->month)->whereYear('created_at',$hoy->year)->get();
	$totalGastos = $gastos->sum('valor');
	$totalIngresos = $pagos->sum('valor');

	return [
		'mes' => [$mes->nombre],
		'año' => $hoy->year,
		'totalGastos' => [$totalGastos],
		'totalIngresos' => [$totalIngresos]
	];

})->name('api.chart.barras');

Route::get('charts/consulta/barras', function() {
	$mesId = request()->mes;
	$ano = request()->ano;
	$nombreMes = App\Mes::find($mesId)->nombre;
	$gastos = \App\Gasto::whereMonth('created_at',$mesId)->whereYear('created_at',$ano)->get();
	$pagos  = \App\Pago::where('estado','Pagado')->whereMonth('created_at',$mesId)->whereYear('created_at',$ano)->get();
	$totalGastos = $gastos->sum('valor');
	$totalIngresos = $pagos->sum('valor');

	return [
		'mes' => [$nombreMes],
		'año' => $ano,
		'totalGastos' => [$totalGastos],
		'totalIngresos' => [$totalIngresos]
	];
})->name('api.chart.barras.consulta');

Route::get('charts/trmiensual/barras', function() {
	$hoy = Carbon\Carbon::now();
	$mesAnt= Carbon\Carbon::now()->subMonth();
	$mesDobleAnt = Carbon\Carbon::now()->subMonths(2);
	$nombreMeses = [];
	$gastosMeses = [];
	$ingresosMeses = [];

	$nombreMeses[0] = \App\Mes::find($mesDobleAnt->month)->nombre;
	$nombreMeses[1] = \App\Mes::find($mesAnt->month)->nombre;
	$nombreMeses[2] = \App\Mes::find($hoy->month)->nombre;
	
	$gastosMeses[0] = \App\Gasto::whereMonth('created_at',$mesDobleAnt->month)->whereYear('created_at',$mesDobleAnt->year)->get()->sum('valor');
	$gastosMeses[1] = \App\Gasto::whereMonth('created_at',$mesAnt->month)->whereYear('created_at',$mesAnt->year)->get()->sum('valor');
	$gastosMeses[2] = \App\Gasto::whereMonth('created_at',$hoy->month)->whereYear('created_at',$hoy->year)->get()->sum('valor');

	$ingresosMeses[0] = \App\Pago::where('estado','Pagado')->whereMonth('created_at',$mesDobleAnt->month)->whereYear('created_at',$mesDobleAnt->year)->get()->sum('valor');
	$ingresosMeses[1] = \App\Pago::where('estado','Pagado')->whereMonth('created_at',$mesAnt->month)->whereYear('created_at',$mesAnt->year)->get()->sum('valor');
	$ingresosMeses[2] = \App\Pago::where('estado','Pagado')->whereMonth('created_at',$hoy->month)->whereYear('created_at',$hoy->year)->get()->sum('valor');

	return [
		'mes' => $nombreMeses,
		'totalGastos' => $gastosMeses,
		'totalIngresos' => $ingresosMeses
	];

})->name('api.chart.barras.trimensual');