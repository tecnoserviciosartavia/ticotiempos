<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Sorteos;
use App\Models\Parametros_sorteos;
use Illuminate\Support\Facades\DB;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $parametros = Parametros_sorteos::where('idusuario', $id)->get();
        if (count($parametros) > 0) {
            $sorteos = Sorteos::all();
            $data = [];
            foreach ($sorteos as $sorteo) {
                $parametro = Parametros_sorteos::where([
                    ['idsorteo',  '=', $sorteo->id],
                    ['idusuario', '=', $id]
                ])->count();
                if ($parametro == 0) {
                    array_push($data, $sorteo);
                }
            }
            $sorteos = $data;
        } else {
            $sorteos = Sorteos::all();
        }
        return view('parametros/index', [
            // Use the top-menu layout
            // Pass data to view
            'users' => User::find($id),
            'sorteos' => $sorteos,
            'parametros' => $parametros,
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
            'paga'      => 'required|digits_between:1,99',
            'comision'  => 'required',
            'idusuario' => 'required',
            'idsorteo'  => 'required',
        ]);


        $parametros = new Parametros_sorteos;

        $parametros->paga      = $request->paga;
        $parametros->comision  = $request->comision;
        $parametros->idusuario = $request->idusuario;
        $parametros->idsorteo  = $request->idsorteo;

        if (!is_null($request->devolucion)) {

            $parametros->devolucion = $request->devolucion;
        }
        if (!is_null($request->monto_arranque)) {

            $parametros->monto_arranque = $request->monto_arranque;
        }
        $parametros->save();
        return redirect()->route('parameter.index', $request->idusuario)->withSuccess(__('Parametro Agregado correctamente.'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $parametro = Parametros_sorteos::find($id);

	    return response()->json([
	      'data' => $parametro
	    ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'paga' => 'required|digits_between:1,99',
            'comision' => 'required',
        ]);

        $parametro = Parametros_sorteos::find($id);
        $parametro->paga     = $request->paga;
        $parametro->comision = $request->comision;

        if (isset($request->devolucion)) {

            $parametro->devolucion = $request->devolucion;

        }
        if (isset($request->monto_arranque)) {

            $parametro->monto_arranque = $request->monto_arranque;

        }
        $parametro->save();
        Session::flash('success', "Parametro Editado correctamente.");
        return response()->json([ 'success' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Parametros_sorteos::find($id);
        $idusuario = $data->idusuario;
        Parametros_sorteos::destroy($id);
        return redirect()->route('parameter.index', $idusuario)->withSuccess(__('Parametro Eliminado correctamente.'));

    }

    public function search_parameters(Request $request)
    {
        $datos = $request->all();
        $callback = Parametros_sorteos::join('sorteos', 'parametros_sorteos.idsorteo', '=', 'sorteos.id')->where([
            ['parametros_sorteos.idusuario', '=',  $datos['idusuario']],
            ['parametros_sorteos.idsorteo', '=', $datos['idsorteo']]
        ])->get(['parametros_sorteos.*', 'sorteos.nombre as name_sorteo']);
        return response()->json(['success'=> $callback]);
    }

    public function usuario($id)
    {
        $parametros = Parametros_sorteos::where('idusuario', $id)->get();

        return view('parametros/agente/index', [
            // Use the top-menu layout
            // Pass data to view
            'parametros' => $parametros,
            'users' => User::find($id),
            'sorteos' => Sorteos::all(),
        ]);
    }
}
