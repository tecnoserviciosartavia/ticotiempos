<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Sorteos;
use App\Models\Venta_detalle;
use App\Models\Venta_cabecera;
use App\Models\Resultados_parametros;
use App\Models\Config_sorteo;
use App\Models\Parametros_sorteos;
use App\Models\User;
use App\Models\Transacciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Jobs\NutrirResultado;
use App\Models\User_balance;

class VentaController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venta_cabecera = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')
        ->join('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
        ->where([
            ['venta_cabecera.fecha', '>=', date('Y-m-d')],
            ['venta_cabecera.hora', '>=', now()->format('H:i')],
            ['venta_cabecera.estatus', '=', 'abierto']
        ])
        ->orderBy(DB::raw('HOUR(venta_cabecera.hora)'))
        ->get(['venta_cabecera.*', 'sorteos.nombre', 'sorteos.logo','sorteos.es_reventado','config_sorteo.restrinccion_numero', 'config_sorteo.restrinccion_monto']);
        return view('venta/agente/index', [
            // Use the top-menu layout
            // Pass data to view
            'clientes' => Clientes::all(),
            'venta_cabecera' => $venta_cabecera,
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
            'numero'      => 'required',
            'monto'       => 'required',
            'cabecera_id' => 'required|integer',
            'cliente_id'  => 'required|integer',
        ]);

        if (!preg_match('/^[0-9 +]+$/i', trim($request->numero))) {

            Session::flash('message', "Agrego un caracter no valido al sistema para ingresar, verifique su solicitud");
            return redirect()->route('venta_sorteo.create');

        }
        //Consulta para ver las restricciones del sorteo
        $config_sorteo = DB::table('venta_cabecera')
        ->leftjoin('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
        ->select('config_sorteo.*')
        ->where('venta_cabecera.id', $request->cabecera_id)
        ->first();
        DB::beginTransaction();

            try {

                if (strpos(trim($request->numero), '+') !== false) {

                    $numeros = explode('+',trim($request->numero));
                    $jugada_padre = Null;
                    for ($i=0; $i < count($numeros); $i++) {
                        if ($numeros[$i] >= 0 AND $numeros[$i] < 100) {
                            if (!is_null($config_sorteo->restrinccion_numero)) {

                                if ($config_sorteo->restrinccion_numero == $numeros[$i]) {

                                    if ($request->monto > $config_sorteo->restrinccion_monto) {
                                        Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                        return redirect()->route('venta_sorteo.create');
                                    }
                                }
                            }
                            $validacio_numero_monto = $this->validaNumeroMonto($numeros[$i],$request->cabecera_id, $request->monto);
                            if ($validacio_numero_monto == false) {
                                Session::flash('message', "El numero excede el monto inicial permitido");
                                return redirect()->route('venta_sorteo.create');
                            }
                            if ($i === 0) {

                                $jugada                   = New Venta_detalle;
                                $jugada->idventa_cabecera = $request->cabecera_id;
                                $jugada->idusuario        = Auth::user()->id;
                                $jugada->idcliente        = $request->cliente_id;
                                $jugada->numero           = $numeros[$i];
                                $jugada->monto            = $request->monto;
                                if ($request->reventado > 0) {
                                    if ($request->monto_reventado > $request->monto) {
                                        Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                        return redirect()->route('venta_sorteo.create');
                                    } else {
                                        $jugada->reventado       = 1;
                                        $jugada->monto_reventado = $request->monto_reventado;
                                    }
                                }
                                $jugada->save();
                                //guardo el padre para las otras apuestas
                                $jugada_padre = $jugada->id;

                            } else {

                                $validacio_numero_monto = $this->validaNumeroMonto($numeros[$i],$request->cabecera_id,$request->monto);
                                if ($validacio_numero_monto == false) {
                                    Session::flash('message', "El numero excede el monto inicial permitido");
                                    return redirect()->route('venta_sorteo.create');
                                }
                                $jugada                   = New Venta_detalle;
                                $jugada->idventa_cabecera = $request->cabecera_id;
                                $jugada->idusuario        = Auth::user()->id;
                                $jugada->idcliente        = $request->cliente_id;
                                $jugada->numero           = $numeros[$i];
                                $jugada->monto            = $request->monto;
                                $jugada->jugada_padre     = $jugada_padre;
                                if ($request->reventado > 0) {
                                    if ($request->monto_reventado > $request->monto) {
                                        Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                        return redirect()->route('venta_sorteo.create');
                                    } else {
                                        $jugada->reventado       = 1;
                                        $jugada->monto_reventado = $request->monto_reventado;
                                    }
                                }
                                $jugada->save();

                            }
                        } else {
                            Session::flash('message', "El numero debe ser menor a 100 y mayor o igual a 0");
                            return redirect()->route('venta_sorteo.create');
                        }
                    }
                } else {

                    if ($request->numero >= 0 AND $request->numero < 100) {

                        $jugada                   = New Venta_detalle;
                        $jugada->idventa_cabecera = $request->cabecera_id;
                        $jugada->idusuario        = Auth::user()->id;
                        $jugada->idcliente        = $request->cliente_id;
                        $jugada->numero           = $request->numero;
                        $jugada->monto            = $request->monto;

                        if (!is_null($config_sorteo->restrinccion_numero)) {

                            if ($config_sorteo->restrinccion_numero == $request->numero) {

                                if ($request->monto > $config_sorteo->restrinccion_monto) {

                                    Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                    return redirect()->route('venta_sorteo.create');

                                }
                            }
                        }
                        $validacio_numero_monto = $this->validaNumeroMonto($request->numero,$request->cabecera_id,$request->monto);
                            if ($validacio_numero_monto == false) {
                                Session::flash('message', "El numero excede el monto inicial permitido");
                                return redirect()->route('venta_sorteo.create');
                            }
                        if ($request->reventado > 0) {
                            if ($request->monto_reventado > $request->monto) {
                                Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                return redirect()->route('venta_sorteo.create');
                            } else {
                                $jugada->reventado       = 1;
                                $jugada->monto_reventado = $request->monto_reventado;
                            }
                        }
                        $jugada->save();
                        //guardo el padre para las otras apuestas
                        $jugada_padre = $jugada->id;
                    } else {

                        Session::flash('message', "El numero debe ser menor a 100 y mayor o igual a 0");
                        return redirect()->route('venta_sorteo.create');
                    }

                }
                DB::commit();
                return redirect()->route('venta_sorteo.edit', $jugada_padre)->withSuccess(__('Jugada creada correctamente.'));
            } catch (\Exception $e) {

                DB::rollBack();
                Session::flash('message', "No se pudo completar el guardado");
                return response()->json([ 'success' => true ]);
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = new ClientesController;
        $callback = $cliente->traer_cliente_venta($id);
        $v_detalle = Venta_detalle::find($id);
        $venta_cabecera = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')->where([
            ['venta_cabecera.id', '=', $v_detalle->idventa_cabecera]
        ])->get(['venta_cabecera.*', 'sorteos.nombre']);
        $venta_cabecera = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')
        ->join('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
        ->where([
            ['venta_cabecera.id', '=', $v_detalle->idventa_cabecera]
        ])->get(['venta_cabecera.*', 'sorteos.nombre', 'sorteos.logo', 'sorteos.es_reventado','config_sorteo.restrinccion_numero', 'config_sorteo.restrinccion_monto']);
        return view('venta/agente/edit', [
            // Use the top-menu layout
            // Pass data to view
            'clientes' => Clientes::all(),
            'venta_detalle' => $callback,
            'venta_cabecera' => $venta_cabecera,
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
        //QUERY PARA SABER CUAL ES EL PADRE DE LA VENTA
        $v_detalle      = Venta_detalle::find($id);
        $cliente        = new ClientesController;
        $callback       = $cliente->traer_cliente_venta($id);
        //QUERY PARA SABER LA CABECERA A LA CUAL PERTENECE
        $venta_cabecera = Venta_detalle::join('venta_cabecera', 'venta_detalle.idventa_cabecera', '=', 'venta_cabecera.id')
        ->where('venta_detalle.id', $id)
        ->where('venta_detalle.idusuario', Auth::user()->id)
        ->first();
        //QUERY PARA CONSULTA DE COMISION DEL USUARIO
        $parametos_sorteo = Parametros_sorteos::where([
            ['idsorteo', '=', $venta_cabecera->idsorteo],
            ['idusuario', '=', $v_detalle->idusuario]
        ])->first();
        // QUERY PARA CONSULTA DE USUARIO
        $usuario              = User::where('id', $v_detalle->idusuario)->first();
        // PROCESO DE CALCULOS Y UPDATES DE SALDOS Y DE MONTOS DE VENTAS
        $monto_venta          = $venta_cabecera->monto_venta;
        $saldo_actual         = $usuario->saldo_actual;
        $total_comision       = 0;
        $monto_transaccion    = 0;
        $comision_transaccion = 0;
        foreach ($callback as $jugada) {
            $comision_usuario      = (($jugada->monto + $jugada->monto_reventado ) * $parametos_sorteo->comision) /100;
            $monto_venta           = $monto_venta + (($jugada->monto + $jugada->monto_reventado )  - $comision_usuario);
            $saldo_actual          = $saldo_actual + (($jugada->monto + $jugada->monto_reventado )  - $comision_usuario);
            $total_comision       += $comision_usuario;
            $comision_transaccion += (($jugada->monto + $jugada->monto_reventado ) * $parametos_sorteo->comision) /100;
            $monto_transaccion    += (($jugada->monto + $jugada->monto_reventado )  - $comision_transaccion);
            Venta_detalle::where('id', $jugada->id)
            ->update(['estatus' => 'apostada']);
        }
        //ACTUALIZO LA CABECERA CON EL MONTO DE LA VENTA
        Venta_cabecera::where('id', $venta_cabecera->id)
        ->update(['monto_venta' => $monto_venta]);
        //ACTUALIZO EL USUARIO CON EL SALDO DEL USUARIO
        User::where('id', $usuario->id)
        ->update(['saldo_actual' => $saldo_actual]);

        // Guardado a la tabla de transacciones de comisiones y de venta
        $data = [
            ['idusuario' => $v_detalle->idusuario, 'monto' => $monto_transaccion, 'concepto' => 'REGISTRO DE VENTA POS USUARIO',  'tipo_concepto' => 'venta' ,'json_dinamico' => json_encode($callback), 'created_at'=> now()],
            ['idusuario' => $v_detalle->idusuario, 'monto' => $comision_transaccion, 'concepto' => 'REGISTRO DE COMISION POR VENTA POS USUARIO', 'tipo_concepto' => 'comision' , 'json_dinamico' => json_encode($callback), 'created_at'=> now()],
        ];
        DB::table('transacciones')->insert($data);

        //Actualizo Saldos Nuevo Update V2.0
        $user_balance = New User_balance;
        $user_balance->actualizarSaldoConVentasyComisiones($usuario->id, $monto_transaccion, $comision_transaccion);
        Session::flash('success', "Apuesta Registrada correctamente.");
        return response()->json([ 'success' => true,'redirect' => url('venta-'.$id.'-imprimir')]);
    }

    public function deleteDetalle($id)
    {
        $ventas = Venta_detalle::find($id);
        // validar para ver si es una jugada padre y poder borrar la padre pero que vivan las hijas y no queden huerfanas
        if (is_null($ventas->jugada_padre)) {

            $jugada_padre = Venta_detalle::where('jugada_padre', '=', $id)->get();
            if (count($jugada_padre) > 0) {

                $nuevo_padre = Venta_detalle::where('jugada_padre', '=', $id)->first();
                Venta_detalle::where('id', $nuevo_padre->id)
                ->update(['jugada_padre' => null]);
                $jpadre = Venta_detalle::where('jugada_padre', '=', $id)->get();
                foreach ($jpadre as $jugada) {

                    Venta_detalle::where('id', $jugada->id)
                    ->update(['jugada_padre' => $nuevo_padre->id]);
                }
                Venta_detalle::destroy($id);
                Session::flash('success', "Jugada Eliminada correctamente.");
                return response()->json([ 'success' => true, 'delete_father' => true ,'redirect' => url('venta-sorteo-'.$nuevo_padre->id.'-edit')]);
            } else {

                Venta_detalle::destroy($id);
                Session::flash('success', "Jugada Eliminada correctamente.");
                return response()->json([ 'success' => true, 'delete_father' => true ,'redirect' => url('venta-sorteo-create')]);
            }
        } else {

            Venta_detalle::destroy($id);
            Session::flash('success', "Jugada Eliminada correctamente.");
            return response()->json([ 'success' => true, 'delete_father' => false]);
        }

    }

    public function juegos()
    {

        $venta_cabecera = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')->where([
            ['venta_cabecera.fecha', '>=', date('Y-m-d')],
            ['venta_cabecera.estatus', '=', 'abierto']
        ])->orderBy('venta_cabecera.hora', 'asc')->get(['venta_cabecera.*', 'sorteos.nombre']);
        return view('venta/admin/index', [
            // Use the top-menu layout
            // Pass data to view
            'venta_cabecera' => $venta_cabecera,
        ]);
    }

    public function abrir()
    {
        $hoy = $this->buscar_fecha();
        $sorteos = Sorteos::where('estatus', 1)->get();
        foreach ($sorteos as $sorteo) {

            $dias = json_decode($sorteo->dias);
            if (in_array("".$hoy, $dias)) {

                $guardado = $this->guardar_juego($sorteo->id);
                continue;
            } else {
                //si entra en esta validacion es porque no juega para el martes el sorteo
                continue;
            }
        }

        return redirect()->route('juegos.index')->withSuccess(__('Sorteos Abiertos correctamente.'));
    }

    public function guardar_juego($idsorteo)
    {
        $sorteo          = Sorteos::find($idsorteo);
        $dt              = Carbon::now();
        $consulta_previa = Venta_cabecera::where('idsorteo', $idsorteo)->where('fecha', '=', $dt->toDateString())->get();

        if (count($consulta_previa) > 0) {
            Log::error('Ya existe este juego abierto');
            return true;
        }
        DB::beginTransaction();

        try {

            $config                = Config_sorteo::where('idsorteo', $idsorteo)->first();
            $juego                 = New Venta_cabecera;
            $juego->idsorteo       = $idsorteo;
            $juego->idconfigsorteo = $config->id;
            $juego->fecha          = $dt->toDateString();
            $juego->hora           = $sorteo->hora;
            $juego->estatus        = 'abierto';
            $juego->cierra_antes   = 10;
            $juego->monto_venta    = '0.00000';
            $juego->save();
            DB::commit();
            return true;

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function buscar_fecha(){

        $dt = Carbon::now();
        $date_onleters = $dt->format('l');
        switch ($dt->dayOfWeek) {
            case Carbon::MONDAY:
                $dia_numero = 1;
            break;
            case Carbon::TUESDAY:
                $dia_numero = 2;
            break;
            case Carbon::WEDNESDAY:
                $dia_numero = 3;
            break;
            case Carbon::THURSDAY:
                $dia_numero = 4;
            break;
            case Carbon::FRIDAY:
                $dia_numero = 5;
            break;
            case Carbon::SATURDAY:
                $dia_numero = 6;
            break;
            case Carbon::SUNDAY:
                $dia_numero = 7;
            break;
        }
        return $dia_numero;
    }

    public function ventaPadre(Request $request, $id)
    {

        if (!preg_match('/^[0-9 +]+$/i', trim($request->numero))) {

            Session::flash('message', "Agrego un caracter no valido al sistema para ingresar, verifique su solicitud");
            return redirect()->route('venta_sorteo.create');

        }

        if (strpos(trim($request->numero), '+') !== false) {
            $numeros = explode('+',trim($request->numero));
            DB::beginTransaction();

            try {

                for ($i=0; $i < count($numeros); $i++) {

                    if ($numeros[$i] >= 0 AND $numeros[$i] < 100) {

                        //Valido si ya el numero se guardo primeramente.
                        $validacion_numero_guardado = $this->validarNumeroGuardadoPadreHijo($id, $numeros[$i], $request->monto);
                        //Consulta para ver las restricciones del sorteo
                        $config_sorteo = DB::table('venta_cabecera')
                        ->leftjoin('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
                        ->select('config_sorteo.*')
                        ->where('venta_cabecera.id', $request->cabecera_id)
                        ->first();

                        if ($validacion_numero_guardado == false) {

                            if (!is_null($config_sorteo->restrinccion_numero)) {

                                if ($config_sorteo->restrinccion_numero == $numeros[$i]) {

                                    if ($request->monto > $config_sorteo->restrinccion_monto) {

                                        Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                        return response()->json([ 'success' => false ]);

                                    }
                                }
                            }
                            $validacio_numero_monto = $this->validaNumeroMonto($numeros[$i],$request->cabecera_id, $request->monto);
                            if ($validacio_numero_monto == false) {
                                Session::flash('message', "El numero excede el monto inicial permitido");
                                return redirect()->route('venta_sorteo.create');
                            }
                            $jugada                     = New Venta_detalle;
                            $jugada->idventa_cabecera   = $request->cabecera_id;
                            $jugada->idusuario          = Auth::user()->id;
                            $jugada->idcliente          = $request->cliente_id;
                            $jugada->numero             = $numeros[$i];
                            $jugada->monto              = $request->monto;
                            if ($request->reventado > 0) {
                                if ($request->monto_reventado > $request->monto) {
                                    Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                    return redirect()->route('venta_sorteo.create');
                                } else {
                                    $jugada->reventado       = 1;
                                    $jugada->monto_reventado = $request->monto_reventado;
                                }
                            }
                            $jugada->jugada_padre       = $id;
                            $jugada->save();

                        } elseif ($validacion_numero_guardado == 'error') {

                            Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                            return response()->json([ 'success' => false ]);

                        } else {

                            $v_detalle = Venta_detalle::find($validacion_numero_guardado);

                            if (!is_null($config_sorteo->restrinccion_numero)) {

                                if ($config_sorteo->restrinccion_numero == $numeros[$i]) {

                                    if (($v_detalle->monto + $request->monto) > $config_sorteo->restrinccion_monto) {

                                        Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                        return response()->json([ 'success' => false ]);

                                    }
                                }
                            }
                            $validacio_numero_monto = $this->validaNumeroMonto($numeros[$i],$request->cabecera_id, $request->monto);
                            if ($validacio_numero_monto == false) {
                                Session::flash('message', "El numero excede el monto inicial permitido");
                                return redirect()->route('venta_sorteo.create');
                            }
                            if ($request->reventado > 0) {
                                if ($request->monto_reventado > $v_detalle->monto) {
                                    Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                    return redirect()->route('venta_sorteo.create');
                                } else {
                                    $v_detalle->reventado       = 1;
                                    $v_detalle->monto_reventado += $request->monto_reventado;
                                }
                            }
                            $v_detalle->monto = $v_detalle->monto + $request->monto;
                            $v_detalle->save();
                        }

                    } else {

                        Session::flash('message', "El numero debe ser menor a 100 y mayor o igual a 0");
                        return response()->json([ 'success' => false ]);
                    }

                }
                DB::commit();
                Session::flash('success', "Numeros Agregados correctamente.");
                return response()->json([ 'success' => true ]);
            } catch (\Exception $e) {

                DB::rollBack();
                Session::flash('message', "No se pudo completar el guardado");
                return response()->json([ 'success' => true ]);
            }

        } else {

            if ($request->numero >= 0 AND $request->numero < 100) {
                DB::beginTransaction();
                try {

                    //Valido si ya el numero se guardo primeramente.
                    $validacion_numero_guardado = $this->validarNumeroGuardadoPadreHijo($id, $request->numero, $request->monto);
                    Log::error(json_encode($validacion_numero_guardado));
                    //Consulta para ver las restricciones del sorteo
                    $config_sorteo = DB::table('venta_cabecera')
                    ->leftjoin('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
                    ->select('config_sorteo.*')
                    ->where('venta_cabecera.id', $request->cabecera_id)
                    ->first();

                    if ($validacion_numero_guardado == false) {

                        if (!is_null($config_sorteo->restrinccion_numero)) {

                            if ($config_sorteo->restrinccion_numero == $request->numero) {

                                if ($request->monto > $config_sorteo->restrinccion_monto) {

                                    Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                    return response()->json([ 'success' => false ]);

                                }
                            }
                        }
                        $validacio_numero_monto = $this->validaNumeroMonto($request->numero,$request->cabecera_id, $request->monto);
                        if ($validacio_numero_monto == false) {
                            Session::flash('message', "El numero excede el monto inicial permitido");
                            return redirect()->route('venta_sorteo.create');
                        }
                        $v_detalle                = Venta_detalle::find($id);
                        $jugada                   = New Venta_detalle;
                        $jugada->idventa_cabecera = $request->cabecera_id;
                        $jugada->idusuario        = Auth::user()->id;
                        $jugada->idcliente        = $request->cliente_id;
                        $jugada->numero           = $request->numero;
                        $jugada->monto            = $request->monto;
                        if ($request->reventado > 0) {
                            if ($request->monto_reventado > $request->monto) {
                                Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                return redirect()->route('venta_sorteo.create');
                            } else {
                                $jugada->reventado       = 1;
                                $jugada->monto_reventado = $request->monto_reventado;
                            }
                        }
                        $jugada->jugada_padre     = $id;
                        $jugada->save();
                        DB::commit();
                        Session::flash('success', "Numero Agregado correctamente.");
                        return response()->json([ 'success' => true ]);

                    } elseif ($validacion_numero_guardado == 'error') {
                        DB::rollBack();
                        Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                        return response()->json([ 'success' => false ]);

                    } else {

                        $v_detalle = Venta_detalle::find($validacion_numero_guardado);

                        if (!is_null($config_sorteo->restrinccion_numero)) {

                            if ($config_sorteo->restrinccion_numero == $request->numero) {

                                if (($v_detalle->monto + $request->monto) > $config_sorteo->restrinccion_monto) {

                                    Session::flash('message', "El numero tiene restrinccion en monto, colocar un monto diferente");
                                    return response()->json([ 'success' => false ]);

                                }
                            }
                        }
                        $validacio_numero_monto = $this->validaNumeroMonto($request->numero,$request->cabecera_id, $request->monto + $v_detalle->monto);
                        if ($validacio_numero_monto == false) {
                            Session::flash('message', "El numero excede el monto inicial permitido");
                            return redirect()->route('venta_sorteo.create');
                        }
                        $v_detalle->monto = $v_detalle->monto + $request->monto;
                        if ($request->reventado > 0) {
                            if ($request->monto_reventado > $v_detalle->monto) {
                                Session::flash('message', "El monto de reventado es mayor al monto de jugada, colocar un monto reventado diferente");
                                return redirect()->route('venta_sorteo.create');
                            } else {
                                $v_detalle->reventado       = 1;
                                $v_detalle->monto_reventado += $request->monto_reventado;
                            }
                        }
                        $v_detalle->save();
                        DB::commit();

                        Session::flash('success', "Numero Agregado correctamente.");
                        return response()->json([ 'success' => true ]);
                    }
                } catch (\Exception $e) {

                    DB::rollBack();
                    Session::flash('message', "No se pudo completar el guardado");
                    return response()->json([ 'success' => true ]);
                }
            } else {

                Session::flash('message', "El numero debe ser menor a 100 y mayor o igual a 0");
                return response()->json([ 'success' => false ]);
            }
        }
    }

    public function validarNumeroGuardadoPadreHijo($id_padre, $numero, $monto){
        $venta_detalle_padre = Venta_detalle::find($id_padre);
        $venta_detalle_hijos = Venta_detalle::where('jugada_padre', '=', $id_padre)->where('numero', '=', $numero)->get();

        if ($venta_detalle_padre->numero == $numero) {
            return $id_padre;
        }

        if (count($venta_detalle_hijos) > 0) {

            $monto_numero = Venta_detalle::where('jugada_padre', '=', $id_padre)->where('numero', '=', $numero)->sum('monto');

            $config_sorteo = DB::table('venta_cabecera')
            ->leftjoin('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
            ->select('config_sorteo.*')
            ->where('venta_cabecera.id', $venta_detalle_padre->idventa_cabecera)
            ->first();
            if (!is_null($config_sorteo->restrinccion_numero) and $numero == $config_sorteo->restrinccion_numero) {

                if (($monto_numero + $monto) > $config_sorteo->restrinccion_monto) {

                    return 'error';
                } else {

                    return $venta_detalle_hijos[0]->id;
                }
            } else {

                return $venta_detalle_hijos[0]->id;
            }
        } else {

            return false;
        }

    }

    public function cambiarClienteVenta(Request $request){

        $cliente = new ClientesController;
        $callback = $cliente->traer_cliente_venta($request->padre_id);
        foreach ($callback as $jugada) {

            Venta_detalle::where('id', $jugada->id)
            ->update(['idcliente' => $request->cliente_id]);
        }
        Session::flash('success', "Cliente Editado correctamente.");
        return response()->json([ 'success' => true ]);
    }

    // Cerrado de los juegos
    public function cerrar()
    {
        $data = Venta_cabecera::where('venta_cabecera.fecha', '<=', date('Y-m-d'))
        ->where('venta_cabecera.estatus', '=', 'abierto')
        ->get();
        $respuesta = $this->cerrarJuegos($data);
        return redirect()->route('juegos.index')->withSuccess(__('Sorteos Cerrados correctamente.'));
    }

    public function cerrarJuegos($data)
    {
        try {
            $hoy                   = Carbon::now()->toDateString();
            foreach ($data as $juegos) {

                $hora_y_dia_sorteo = Carbon::parse($juegos->fecha.' '.$juegos->hora);
                $fecha_hoy         = $hora_y_dia_sorteo->toDateString();

                if ($fecha_hoy < $hoy) {

                    $borrar        = $this->eliminarJugadasDeSorteos($juegos->id);

                } elseif ($fecha_hoy == $hoy) {

                    $date           = Carbon::now();
                    $hora           = $date->toDateTimeString();
                    $hora_calculada = $hora_y_dia_sorteo->subMinutes($juegos->cierra_antes);

                    if ($hora_calculada <= $hora) {

                        $borrar     = $this->eliminarJugadasDeSorteos($juegos->id);
                    }
                }
            }
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function eliminarJugadasDeSorteos($juegos_id)
    {
        // esta funcion sirve para cerrar algun sorteo en particular pasandole el id y borrando las jugadas
        //que esten en proceso solo debe pasarse el id del juego
        try {

            Venta_cabecera::where('id', $juegos_id)
            ->update(['estatus' => 'cerrado']);
            $detalle = Venta_detalle::where('idventa_cabecera', $juegos_id)
            ->where('estatus', '=', 'en proceso')
            ->get();

            foreach ($detalle as $cada_jugada) {

                Venta_detalle::destroy($cada_jugada->id);
            }
            $venta_cabecera = Venta_cabecera::find($juegos_id);
            if ($venta_cabecera->sorteos->usa_webservice > 0) {

                NutrirResultado::dispatch($venta_cabecera->id)->delay(now()->addMinutes(20));
            }
            return 1;
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
    }

    public function imprimirTicket($id)
    {
        $venta = Venta_detalle::select('venta_detalle.*', 'cliente.num_id', 'cliente.nombre as name_cliente', 'users.name as name_banca', 'users.photo')
        ->join('cliente', 'venta_detalle.idcliente', '=', 'cliente.id')
        ->join('users', 'venta_detalle.idusuario', '=', 'users.id')
        ->where('venta_detalle.id',$id)
        ->get();

        $impresion = $venta[0]->impreso;
        if ($venta[0]->impreso === 0 ) {
            $impresion = 0;
            $venta[0]->updateImpreso(1);
        }
        $venta_cabecera = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')
        ->join('config_sorteo', 'venta_cabecera.idconfigsorteo', '=', 'config_sorteo.id')
        ->where([
            ['venta_cabecera.id', '=', $venta[0]->idventa_cabecera]
        ])->get(['venta_cabecera.*', 'sorteos.nombre', 'sorteos.es_reventado','sorteos.logo', 'config_sorteo.restrinccion_numero', 'config_sorteo.restrinccion_monto']);

        $venta_2 = Venta_detalle::select('venta_detalle.*', 'cliente.num_id', 'cliente.nombre as name_cliente')
        ->join('cliente', 'venta_detalle.idcliente', '=', 'cliente.id')
        ->join('users', 'venta_detalle.idusuario', '=', 'users.id')
        ->where('venta_detalle.jugada_padre',$id)
        ->get();

        $callback = [];
        array_push($callback, $venta[0]);
        foreach ($venta_2 as $jugadas_hijas) {
            //validacion para ir actualizando jugadas hijas impresion
            if ($jugadas_hijas->impreso === 0 ) {
                $jugadas_hijas->updateImpreso(1);
            }
            array_push($callback, $jugadas_hijas);
        }
        $parametros = Parametros_sorteos::where(['idusuario' => $venta[0]->idusuario, 'idsorteo' => $venta_cabecera[0]->idsorteo])->get();
        $bolitas = Resultados_parametros::all();
        return view('venta/agente/imprimir', [
            // Use the top-menu layout
            // Pass data to view
            'venta' => $venta,
            'venta_cabecera' => $venta_cabecera,
            'callback' => $callback,
            'parametros' => $parametros,
            'bolitas' => $bolitas,
            'impresion' => $impresion,
        ]);
    }

    public function verCanjearTicket(){
        $ganador = [];
        $ticket  = '';
        $copiar = 0;
        return view('canjear/agente/index', compact('ganador', 'ticket', 'copiar'));
    }

    public function filtroCanjearTicket(Request $request){
        $ganador     = [];
        $ticket      = $request->ticket_id;
        $traer_padre = $this->traerPadre($request->ticket_id);
        $copiar = 0;
        if ($traer_padre == false) {
            Session::flash('message', "El numero no existe en nuestros tickets");
            return redirect()->route('canjear.index');
        }
        $jugada = Venta_cabecera::select('venta_detalle.*', 'venta_cabecera.idsorteo', 'venta_cabecera.estatus')
        ->leftjoin('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
        ->where('venta_detalle.id',$traer_padre)
        ->first();


        if (!is_null($jugada)) {

            //QUERY PARA CONSULTA DE COMISION DEL USUARIO
            $parametos_sorteo = Parametros_sorteos::where([
                ['idsorteo', '=', $jugada->idsorteo],
                ['idusuario', '=', $jugada->idusuario]
            ])->first();

            $callback = [
                'sorteo' => $jugada->sorteos->nombre,
                'paga' => $parametos_sorteo->paga,
                'id' => $jugada->id,
                'monto' => $jugada->monto,
                'numero' => $jugada->numero,
                'es_ganador' => $jugada->es_ganador,
                'monto_ganador' => $jugada->monto_ganador,
                'jugada_padre' =>  NULL,
                'estatus' =>  $jugada->estatus,
                'fue_pagado' =>  $jugada->fue_pagado,
            ];
            array_push($ganador, $callback);
            $hijas = Venta_detalle::where('jugada_padre', $jugada->id)->get();

            foreach ($hijas as $detalle) {
                $all_callback = [
                    'sorteo' => $jugada->sorteos->nombre,
                    'paga' => $parametos_sorteo->paga,
                    'id' => $detalle->id,
                    'monto' => $detalle->monto,
                    'numero' => $detalle->numero,
                    'es_ganador' => $detalle->es_ganador,
                    'monto_ganador' => $detalle->monto_ganador,
                    'jugada_padre' =>  $jugada->id,
                    'fue_pagado' =>  $detalle->fue_pagado,
                ];
                array_push($ganador, $all_callback);
            }
            //validacion para copiar
            $copy_play = Venta_cabecera::where('idsorteo',$jugada->idsorteo)
            ->where('estatus','=','abierto')
            ->first();
            if (!is_null($copy_play)) {
                $copiar = $copy_play->id;
            }
        }
        return view('canjear/agente/index', compact('ganador', 'ticket', 'traer_padre', 'copiar'));
    }

    public function traerPadre($id){
        try {
            $jugada = Venta_cabecera::select('venta_detalle.*', 'venta_cabecera.idsorteo')
            ->leftjoin('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
            ->where('venta_detalle.id',$id)
            ->first();

            if (!is_null($jugada->jugada_padre)) {
                return $jugada->jugada_padre;
            }

            return $id;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function pagarTicketVenta($id){

        Venta_detalle::where('id',$id)->update(['fue_pagado' => 1]);
        return redirect()->route('canjear.index')->withSuccess(__('Jugada Pagada correctamente.'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copiarTicket($id)
    {
        DB::beginTransaction();

        try {

            //QUERY PARA SABER CUAL ES EL PADRE DE LA VENTA
            $padre_detalle = Venta_detalle::find($id);
            $idventa_cabecera = $padre_detalle->buscarCabecera();
            // Copio la jugada vieja y busco el ID de la cabecera nueva del sorteo que esta abierto
            $jugada                   = New Venta_detalle;
            $jugada->idventa_cabecera = $idventa_cabecera;
            $jugada->idusuario        = $padre_detalle->idusuario;
            $jugada->idcliente        = $padre_detalle->idcliente;
            $jugada->numero           = $padre_detalle->numero;
            $jugada->monto            = $padre_detalle->monto;
            $jugada->reventado        = $padre_detalle->reventado;
            $jugada->monto_reventado  = $padre_detalle->monto_reventado;
            $jugada->save();

            $jugadas_hijas = Venta_detalle::where('jugada_padre', '=', $id)->get();
            if (sizeof($jugadas_hijas) > 0) {

                foreach ($jugadas_hijas as $hijas) {
                    $jugada_son                   = New Venta_detalle;
                    $jugada_son->idventa_cabecera = $idventa_cabecera;
                    $jugada_son->idusuario        = $hijas->idusuario;
                    $jugada_son->idcliente        = $hijas->idcliente;
                    $jugada_son->numero           = $hijas->numero;
                    $jugada_son->monto            = $hijas->monto;
                    $jugada_son->reventado        = $hijas->reventado;
                    $jugada_son->monto_reventado  = $hijas->monto_reventado;
                    $jugada_son->jugada_padre     = $jugada->id;
                    $jugada_son->save();
                }
            }
            DB::commit();
            return redirect()->route('venta_sorteo.edit', $jugada->id)->withSuccess(__('Jugada creada correctamente.'));
        } catch (\Exception $e) {

            DB::rollBack();
            Session::flash('message', "No se pudo copiar el ticket.");
            return redirect()->back();
        }

    }
    public function validaNumeroMonto($numero, $juego_id, $monto)
    {
        $juego = Venta_cabecera::find($juego_id);
        $monto_por_numero = Venta_detalle::where('idventa_cabecera', '=', $juego_id)
        ->where('numero', '=',$numero)
        ->where('estatus', '=','apostada')
        ->sum('monto');
        $monto_calculado = $monto_por_numero + $monto;
        if($juego->sorteos->monto_limite_numero > $monto_calculado){
            return true;
        } else {
            return false;
        }
    }

    public function jsonimprimirTicket($id)
    {
        $detalle        = new Venta_detalle;
        $cabecera       = new Venta_cabecera;
        $parameter      = new Parametros_sorteos;
        $venta          = $detalle->venta1Impresion($id);
        $venta_cabecera = $cabecera->ventaCabeceraImpresion($venta[0]->idventa_cabecera);
        $venta_2        = $detalle->traerJugadasHijas($id);
        $parametros     = $parameter->parametrosImpresion($venta[0]->idusuario, $venta_cabecera[0]->idsorteo);
        $impresion      = $venta[0]->impreso;
        if ($venta[0]->impreso === 0 ) {
            $impresion  = 0;
            $venta[0]->updateImpreso(1);
        }
        $callback = [];
        array_push($callback, $venta[0]);
        foreach ($venta_2 as $jugadas_hijas) {
            //validacion para ir actualizando jugadas hijas impresion
            if ($jugadas_hijas->impreso === 0 ) {
                $jugadas_hijas->updateImpreso(1);
            }
            array_push($callback, $jugadas_hijas);
        }
        $bolitas = Resultados_parametros::all();
        $html = '';
        $html .= '<div class="ticket" style="margin-left:200px;">
                    <p class="centrado">
                    <img alt="TicoTiempos" class="w-6" src="'.  Auth::user()->photo_url .'" style="width: 80px;height: 80px;border-radius: 50%;margin-left: 50px;"><br>                        <b>'. $venta[0]->name_banca .'</b>
                        <br><b>Sorteo:</b>'. $venta_cabecera[0]->nombre .'
                        <br><b>Fecha:</b> '.$venta_cabecera[0]->fecha .'
                        <br><b>Hora:</b>'. $venta_cabecera[0]->hora .'
                        <br><b>Cliente:</b>'. $venta[0]->name_cliente .'
                        <br><b>Identificacion:</b>'. $venta[0]->num_id .'
                        <br><b>Tiquete:</b> '.$venta[0]->id .'
                        <br><b>Fecha de Compra de Tiquete:</b>'.$venta[0]->created_at.'';
                        if (isset($parametros[0]->paga)){
                            $html .= '<br><b>Paga:</b> '. $parametros[0]->paga .'';
                        } else {
                            $html .= '<br><b>Paga:</b> -- Sin Definir --';
                        }
                        $html .='</p><br><table>
                        <thead>
                            <tr>
                                <th class="producto">JUGADA</th>
                                <th class="precio">MONTO</th>';
                        if ($venta_cabecera[0]->es_reventado > 0){
                            $html .= '<th class="precio">REVENTADO</th>';
                        }
                        $html .= '</tr></thead><tbody>';
                        $total_comprobante = 0;
                        foreach($callback as $v){
                            $html .= '<tr>
                                <td class="producto">'.  $v->numero .'</td>
                                <td class="precio"> '.  number_format($v->monto,2,',','.') .'</td>
                                <td class="precio"> '.  number_format($v->monto_reventado,2,',','.') .'</td>
                            </tr>';
                            if ($v->monto_reventado > 0) {
                                $total_comprobante +=  $v->monto + $v->monto_reventado;

                            } else {
                                $total_comprobante +=  $v->monto;
                            }
                        }
                        $html .= '<tr>
                                    <td class="producto"><b><i>Total Comprobante:</i></td>
                                    <td class="precio" colspan="2"><b>'.number_format($total_comprobante,2,',','.') .'</b></td>
                                </tr>
                            </tbody>
                        </table>';
                        $html .= '<p class="centrado">';
                        foreach ($bolitas as $bolita){
                            $html .= '<br><b  style="background-color: '. $bolita->color  .';">'. $bolita->descripcion  .'</b> - <b>Paga: '. $bolita->paga_resultado.'</b>';
                        }
                        $html .= '<br><b>Tecno Servicios Artavia<br></b>
                        Mucha Suerte en el sorteo<br>
                        <b>Nota:</b> tienes 7 días hábiles para canjear su premio.<br>';
                        if ($impresion > 0) {
                            $html .= ' <strong>REIMPRESO NO VALIDO</strong><br>';
                        }
                        $html .= '</p></div>';
        return response()->json(['success'=> $html]);
    }
}
