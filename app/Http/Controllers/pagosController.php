<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Casa;
use App\Pago;
use Alert;

class pagosController extends Controller
{
    public function generarRecibos($mes){
        //$mesLiquidar = Carbon::now()->month;
        if(Pago::all()->last()->mes_id == $mes){
            Alert::error('Los recibos de pago ya fueron generados','¡Error al generar recibos!');
            return redirect()->back();
        }else{
            $mesLiquidar = $mes;
            $valorAPagar = 50000;
            $casas = Casa::all();
            foreach ($casas as $casa) {
                Pago::create(["casa_id"=>$casa->id,"mes_id"=>$mesLiquidar,"valor"=>50000]);
            }
            Alert::success('Recibos de pago generados correctamente!','¡Enhorabuena!');
            return redirect()->back();
        }
    }

    public function realizarPago(){
        $facturaId = Request()->facturaId;
        $factura = Pago::find($facturaId);
        $factura->estado = 'Pagado';
        $factura->fecha_pago = Carbon::now();
        $factura->save();
        return ['Pago listo'];
    }
}
