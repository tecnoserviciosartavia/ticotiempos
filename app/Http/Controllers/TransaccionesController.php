<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacciones;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TransaccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaccion = new Transacciones;
        $transacciones = $transaccion->filtroPorFechaBetween(date('Y-m-d'). ' 00:00:00', date('Y-m-d'). ' 23:59:59', 'all');
        return view('transacciones/index', [
            'transacciones' => $transacciones,
            'usuarios' => User::where('active', 1)->get(),
            'fecha_desde' => date('Y-m-d'),
            'tipo_concepto' => 'all',
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
        $validated = $request->validate(
            [
                'idusuario'              => 'required',
                'concepto'               => 'required',
                'tipo_concepto'          => 'required',
                'monto'                  => 'required',
            ],
            [
                'idusuario.required'     => 'Usuario es Requerido',
                'concepto.required'      => 'Concepto es Requerido',
                'tipo_concepto.required' => 'Tipo de concepto es Requerido',
                'monto.required'         => 'Monto es Requerido',
            ]
        );
        $datos   = $request->except('_token');
        $user    = new User;
        DB::table('transacciones')->insert($datos);

        switch ($datos['tipo_concepto']) {
            case 'premio':
                $user->actualizarSaldoUsuario($request->idusuario, $request->monto);
                $user->actualizarSaldoAdministrador($request->monto, 'resta');
            break;
            case 'retiro':
                $user->actualizarSaldoUsuario($request->idusuario, $request->monto);
                $user->actualizarSaldoAdministrador($request->monto, 'suma');
            break;
            case 'otro':
                $user->actualizarSaldoUsuario($request->idusuario, $request->monto);
                $user->actualizarSaldoAdministrador($request->monto, 'suma');
            break;
        }
        return redirect()->route('transacciones.index')->withSuccess(__('Transaccion Registrada correctamente.'));
    }

    public function filtro_transaccion(Request $request)
    {
        $transaccion         = new Transacciones;

        if ($request->tipo_concepto == 'all') {
            $transacciones   = $transaccion->filtroPorFechaBetween($request->fecha_desde. ' 00:00:00', $request->fecha_desde. ' 23:59:59', 'all');
        } else {
            $transacciones   = $transaccion->filtroPorFechaBetween($request->fecha_desde. ' 00:00:00', $request->fecha_desde. ' 23:59:59', $request->tipo_concepto);
        }
        return view('transacciones/index', [
            'transacciones'  => $transacciones,
            'usuarios'       => User::where('active', 1)->get(),
            'fecha_desde'    => $request->fecha_desde,
            'tipo_concepto'  => $request->tipo_concepto,
        ]);
    }
}
