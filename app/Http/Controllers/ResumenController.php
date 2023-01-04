<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorteos;
use App\Models\Venta_detalle;
use App\Models\Venta_cabecera;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametros_sorteos;

class ResumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resumen/index', [
            'resumen'              => $this->armarResumen(date('Y-m-d'),date('Y-m-d'), Auth::user()->id),
            'fecha_desde'          => date('Y-m-d'),
            'fecha_hasta'          => date('Y-m-d'),
        ]);
    }

    // Resumen Index para la parte del Administrador
    public function resumenAdmin(){
        return view('resumen/admin/index', [
            'resumen'              => $this->armarResumen(date('Y-m-d'),date('Y-m-d'), 'all'),
            'fecha_desde'          => date('Y-m-d'),
            'fecha_hasta'          => date('Y-m-d'),
            'usuarios'             => User::where('active', 1)->get(),
            'usuario_seleccionado' => 'all',
        ]);
    }
    public function filtroAdmin(Request $request)
    {
        return view('resumen/admin/index', [
            'resumen'     => $this->armarResumen($request->fecha_desde,$request->fecha_hasta, $request->usuarios),
            'fecha_desde'          => $request->fecha_desde,
            'fecha_hasta'          => $request->fecha_hasta,
            'usuarios'             => User::where('active', 1)->get(),
            'usuario_seleccionado' => $request->usuarios,
        ]);
    }
    public function filtro_resumen(Request $request)
    {
        return view('resumen/index', [
            'resumen'     => $this->armarResumen($request->fecha_desde,$request->fecha_hasta, Auth::user()->id),
            'fecha_desde' => $request->fecha_desde,
            'fecha_hasta' => $request->fecha_hasta,
        ]);
    }
    // Reporteria para Administrador y para el Usuario
    public function cobro()
    {
        return view('resumen/cobro', [
            'resumen'              => $this->armarCobro(date('Y-m-d'), date('Y-m-d'), 'all'),
            'fecha_desde'          => date('Y-m-d'),
            'fecha_hasta'          => date('Y-m-d'),
            'usuarios'             => User::where('active', 1)->get(),
            'usuario_seleccionado' => 'all',
        ]);
    }
    // Filtro de la reporteria para el administrador y usuario
    public function filtro_cobro(Request $request)
    {
        return view('resumen/cobro', [
            'resumen'              => $this->armarCobro($request->fecha_desde, $request->fecha_hasta, $request->usuarios),
            'fecha_desde'          => $request->fecha_desde,
            'fecha_hasta'          => $request->fecha_hasta,
            'usuarios'             => User::where('active', 1)->get(),
            'usuario_seleccionado' => $request->usuarios,
        ]);
    }
    public function historico()
    {
        return view('resumen/historico', [
            'historico'           => [],
            'sorteos'             => Sorteos::all(),
            'sorteo_seleccionado' => null,
            'fecha_desde'         => date('Y-m-d'),
        ]);
    }
    public function filtro_historico(Request $request)
    {
        $cabecera = Venta_cabecera::where([
            ['idsorteo', '=', $request->idsorteo],
            ['fecha', '=', $request->fecha_desde]
        ])->first();
        $callback = [];
        if (!is_null($cabecera)) {
            $apuestas = Venta_detalle::where([
                ['idusuario', '=', Auth::user()->id],
                ['idventa_cabecera', '=', $cabecera->id],
                ['estatus', '!=', 'en proceso']
            ])->get();
            foreach ($apuestas as  $apuesta) {
                if (array_key_exists($apuesta->numero, $callback)) {
                    $callback[$apuesta->numero] += $apuesta->monto;
                } else {
                    $callback[$apuesta->numero] = $apuesta->monto;
                }
            }
        }
        if (isset($request->idsorteo)) {
            $sorteo = Sorteos::find($request->idsorteo);
        }
        return view('resumen/historico', [
            'historico'           => $callback,
            'sorteos'             => Sorteos::all(),
            'sorteo_seleccionado' => $sorteo,
            'fecha_desde'         => $request->fecha_desde,
        ]);
    }
    public function buscarComision($array)
    {
        $callback = [];
        foreach ($array as $resumen) {
            $detalle = Venta_detalle::where("idventa_cabecera", '=', $resumen['id'])->get();
            $parametro = Parametros_sorteos::where([
                ['idusuario', '=', $detalle[0]->idusuario],
                ['idsorteo', '=', $resumen['idsorteo']],
            ])->first();
            $comision        = ($resumen['monto_venta'] * $parametro->comision)/100;
            $balance         = $resumen['monto_venta'] - $comision - $resumen['premio'];
            $detail_callback = [
                'nombre_sorteo' => $resumen['nombre'],
                'fecha_sorteo'  => $resumen['fecha'],
                'hora_sorteo'   => $resumen['hora'],
                'importe'       => $resumen['monto_venta'],
                'comision'      => $comision,
                'premio'        => $resumen['premio'],
                'balance'       => $balance,
            ];
            array_push($callback, $detail_callback);
        }
        return $callback;
    }



    public function armarResumen($desde, $hasta, $idusuario){
        $cabecera = New Venta_cabecera();
        $detalle  = New Venta_detalle();
        $resumen  = [];
        foreach ($cabecera->traerCabeceraParaResumen($desde,$hasta) as $res) {
            $callback = [
                'nombre'         =>  $res->sorteos->nombre,
                'fecha'          =>  $res->fecha,
                'numero_ganador' =>  $res->numero_ganador,
                'id'             =>  $res->id,
            ];
            if (Auth::user()->es_administrador > 0) {
                if ($idusuario == 'all') {
                    $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, NULL);
                } else {
                    $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, $idusuario);
                }
            } else {
                $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, Auth::user()->id);
            }
            array_push($resumen, $callback);
        }
        return $resumen;
    }

    public function armarCobro($desde, $hasta, $usuario){
        $cabecera = New Venta_cabecera();
        $detalle  = New Venta_detalle();
        $resumen  = [];
        foreach ($cabecera->traerCabeceraParaResumen($desde,$hasta) as $res) {
            $callback = [
                'nombre'         =>  $res->sorteos->nombre,
                'fecha'          =>  $res->fecha,
                'numero_ganador' =>  $res->numero_ganador,
                'hora'           =>  $res->hora,
                'id'             =>  $res->id,
                'idsorteo'       =>  $res->idsorteo,
            ];
            if (Auth::user()->es_administrador > 0) {
                if ($usuario != 'all') {
                    $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, $usuario);
                    $callback['premio']      =  $detalle->traerMontoPremioPorSorteo($res->id, $usuario);

                } else {
                    $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, NULL);
                    $callback['premio']      =  $detalle->traerMontoPremioPorSorteo($res->id, NULL);
                }
            } else {
                $callback['monto_venta'] = $detalle->traerMontoVentaPorCabeceraYUsuario($res->id, Auth::user()->id);
                $callback['premio']      =  $detalle->traerMontoPremioPorSorteo($res->id, Auth::user()->id);
            }
            array_push($resumen, $callback);
        }
        $callback = $this->buscarComision($resumen);
        return $callback;
    }

    public function jugadas(Request $request, $id)
    {
        $datos = $request->all();
        if (Auth::user()->es_administrador > 0) {
            $apuestas = Venta_detalle::where([
                ['idventa_cabecera', '=', $id],
                ['estatus', '!=', 'en proceso']
            ])->get();
        } else {
            $apuestas = Venta_detalle::where([
                ['idusuario', '=', Auth::user()->id],
                ['idventa_cabecera', '=', $id],
                ['estatus', '!=', 'en proceso']
            ])->get();
        }
        $callback = [];
        foreach ($apuestas as  $apuesta) {
            if (array_key_exists($apuesta->numero, $callback)) {
                $callback[$apuesta->numero] += $apuesta->monto;
            } else {
                $callback[$apuesta->numero] = $apuesta->monto;
            }
        }
        return response()->json(['success'=> $callback]);
    }

    public function ganadoras(Request $request, $id)
    {
        $datos = $request->all();
        if (Auth::user()->es_administrador > 0) {
            $ganadoras = Venta_detalle::where([
                ['idventa_cabecera', '=', $id],
                ['estatus', '=', 'ganadora'],
                ['es_ganador', '=', 1]
            ])->get();
        } else {
            $ganadoras = Venta_detalle::where([
                ['idusuario', '=', Auth::user()->id],
                ['idventa_cabecera', '=', $id],
                ['estatus', '=', 'ganadora'],
                ['es_ganador', '=', 1]
            ])->get();
        }
        return response()->json(['success'=> $ganadoras]);
    }
}
