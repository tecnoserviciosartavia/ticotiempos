<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_balance;
use App\Models\Transacciones;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cuentas/index', [
            // Use the top-menu layout
            // Pass data to view
            'users' => User::all(),
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
        if (Auth::user()->es_administrador) {
            //Reviso si el balance es menor al solicitado
            $balance     = New User_balance;
            if ($balance->checkearSaldoParaRetiro($request->usuario_id, $request->monto) == false) {
                Session::flash('message', "El saldo anterior del usuario es menor al solicitado para el retiro");
                return redirect()->route('cuentas.index');
            }
            $transaccion                = New Transacciones;
            $transaccion->idusuario     = $request->usuario_id;
            $transaccion->monto         = $request->monto;
            $transaccion->concepto      = $request->concepto;
            $transaccion->tipo_concepto = 'retiro';
            $transaccion->json_dinamico = NULL;
            $transaccion->created_at    = date('Y-m-d');
            $transaccion->updated_at    = date('Y-m-d');
            $transaccion->save();
            $user                       = new User;
            $user->actualizarSaldoUsuario($request->idusuario, $request->monto);
            $user->actualizarSaldoAdministrador($request->monto, 'suma');
            return redirect()->route('cuentas.index')->withSuccess(__('Retiro Agregado correctamente.'));

        } else {

            Session::flash('message', "El usuario debe ser administrador para realizar un retiro");
            return redirect()->route('cuentas.index');
        }
    }
}
