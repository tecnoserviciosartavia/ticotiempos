<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta_cabecera;
use App\Models\Resultados_parametros;
use App\Jobs\CalculateWinners;
use App\Jobs\RecalculateWinners;

class ResultadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venta_cabecera = Venta_cabecera::where('estatus', '=', 'cerrado')
        ->where('fecha', '=', date('Y-m-d'))
        ->orderBy('fecha', 'desc')
        ->get();
        return view('resultados/index', [
            'venta_cabecera'        => $venta_cabecera,
            'resultados_parametros' => Resultados_parametros::all(),
            'fecha_desde'           => date('Y-m-d'),
            'estatus'               => 'cerrado',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_ganador'     => 'required',
            'adicional_ganador'  => 'required',
            'idventa_cabecera'   => 'required',
        ]);
        Venta_cabecera::where('id', $request->idventa_cabecera)
        ->update([
            'numero_ganador'    => $request->numero_ganador,
            'adicional_ganador' => $request->adicional_ganador,
        ]);
        CalculateWinners::dispatch($request->idventa_cabecera);
        return redirect()->route('resultados.index')->withSuccess(__('Resultado Agregado correctamente.'));

    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'numero_ganador'     => 'required',
            'adicional_ganador'  => 'required',
            'idventa_cabecera'   => 'required',
        ]);
        RecalculateWinners::dispatch($request->idventa_cabecera, $request->numero_ganador, $request->adicional_ganador);
        CalculateWinners::dispatch($request->idventa_cabecera)->delay(30);
        return response()->json([ 'success' => true]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resultadosParametros()
    {
        return view('resultados/config', [
            'resultados_parametros' => Resultados_parametros::all(),
        ]);
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParametros(Request $request)
    {
        $validated = $request->validate([
            'descripcion'     => 'required|min:1|max:2',
            'color'           => 'required',
            'paga_resultado'  => 'required',
        ]);
        $parametros                 = new Resultados_parametros;
        $parametros->descripcion    = $request->descripcion;
        $parametros->color          = $request->color;
        $parametros->paga_resultado = $request->paga_resultado;
        $parametros->save();
        return redirect()->route('resultados.parameters')->withSuccess(__('Parametro Agregado correctamente.'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtro_resultado(Request $request)
    {
        if ($request->estatus == 'all') {
            $resultado = Venta_cabecera::where('fecha', '=', $request->fecha_desde)
            ->orderBy('fecha', 'desc')
            ->get();
        } else {
            $resultado = Venta_cabecera::where('fecha', '=', $request->fecha_desde)
            ->where('estatus', '=', $request->estatus)
            ->orderBy('fecha', 'desc')
            ->get();
        }
        return view('resultados/index', [
            'venta_cabecera'        => $resultado,
            'resultados_parametros' => Resultados_parametros::all(),
            'fecha_desde'           => $request->fecha_desde,
            'estatus'               => $request->estatus,
        ]);
    }
}
