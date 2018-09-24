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
        if( Pago::all()->count() == 0 ){
            $mesLiquidar = $mes;
            $valorAPagar = 50000;
            $casas = Casa::all();
            foreach ($casas as $casa) {
                Pago::create(
                    [
                        "casa_id"=>$casa->id,
                        "mes_id"=>$mesLiquidar,
                        "valor"=>$valorAPagar,
                        "saldo"=>$valorAPagar
                    ]);
            }
            Alert::success('Recibos de pago generados correctamente!','¡Enhorabuena!');
            return redirect()->back();
        }
        
        if(Pago::all()->last()->mes_id == $mes){
            Alert::error('Los recibos de pago ya fueron generados','¡Error al generar recibos!');
            return redirect()->back();
        }else{
            $mesLiquidar = $mes;
            $valorAPagar = 50000;
            $casas = Casa::all();
            foreach ($casas as $casa) {
                Pago::create(
                    [
                        "casa_id"=>$casa->id,
                        "mes_id"=>$mesLiquidar,
                        "valor"=>$valorAPagar,
                        "saldo"=>$valorAPagar
                    ]);
            }
            Alert::success('Recibos de pago generados correctamente!','¡Enhorabuena!');
            return redirect()->back();
        }
    }

    public function realizarPago(){
        $facturaId = Request()->facturaId;
        $factura = Pago::find($facturaId);
        $factura->estado = 'Pagado';
        $factura->valorPagado = 50000;
        $factura->saldo = $factura->valor - $factura->valorPagado;
        $factura->fecha_pago = Carbon::now();
        $factura->save();
        return ['bandera' => 1];
    }

    public function abonarPago(){
        $facturasId = Request()->facturasId;
        if(count($facturasId) == 1){
            $factura = Pago::find($facturasId[0]);
            $pagoAnterior = $factura->valorPagado;
            $factura->valorPagado = Request()->abono;
            $factura->saldo = $factura->saldo - $factura->valorPagado;
            if($factura->saldo == 0){
                $factura->estado = 'Pagado';
            }
            $factura->valorPagado += $pagoAnterior;
            $factura->fecha_pago = Carbon::now();
            $factura->save();
            return ['bandera' => 1];
        }else{
            //multiples facturas
            return ['bandera' => 0];
        }
        
    }

    public function showPago($id){
        $pago = Pago::find($id);
        return view('showReciboPago',compact('pago'));
    }
}
