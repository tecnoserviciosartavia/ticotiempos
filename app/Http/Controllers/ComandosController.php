<?php

namespace App\Http\Controllers;

use App\Models\Transacciones;
use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Jobs\NutrirSaldosActualizados;

class ComandosController extends Controller
{
    public function startDelete(){
        $fecha = Carbon::now()->subMonths(6);
        //Borrar Transacciones
        try {
            $this->borrarTransacciones($fecha);
        } catch (Throwable $exception) {
            Log::error('Error al borrar Transacciones');
            Log::error($exception->getMessage());
        }

        //Borrar detalle
        try {
            $this->borrarVentaDetalle($fecha);
        } catch (Throwable $exception) {
            Log::error('Error al borrar VentaDetalle');
            Log::error($exception->getMessage());
        }

        //Borrar cabecera
        try {
            $this->borrarVentaCabecera($fecha);
        } catch (Throwable $exception) {
            Log::error('Error al borrar VentaCabecera');
            Log::error($exception->getMessage());
        }
    }

    public function borrarTransacciones($fecha_calculada){
        $transacciones = Transacciones::where('created_at', '<=', $fecha_calculada)->delete();
    }
    public function borrarVentaDetalle($fecha_calculada){
        $venta_detalle = Venta_detalle::where('created_at', '<=', $fecha_calculada)->delete();
    }
    public function borrarVentaCabecera($fecha_calculada){
        $venta_cabecera = Venta_cabecera::where('created_at', '<=', $fecha_calculada)->delete();
    }
    public function startBalanceInit(){
        NutrirSaldosActualizados::dispatch();
    }
}
