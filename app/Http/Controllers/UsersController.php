<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Sorteos;
use App\Models\Parametros_sorteos;
use App\Models\Transacciones;
use App\Models\Venta_detalle;
use App\Models\Venta_cabecera;
use App\Http\Controllers\ComandosController;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users/index', [
            'users'  => User::where('active', 1)->get(),
            'active' => 1,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users/crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $model)
    {
        $request->validate(
            [
                'name'                  => 'required',
                'password'              => 'required|min:6',
                'email'                 => 'required|email|unique:users',
                'gender'                => 'required',
                'comision'              => 'required',
                'paga'                  => 'required',
                'monto_limite_numero'   => 'required',
            ],
            [
                'name.required'                      => 'Nombre es Requerido',
                'gender.required'                    => 'Sexo es Requerido',
                'paga.required'                      => 'Paga es Requerido',
                'comision.required'                  => 'Comision es Requerido',
                'monto_limite_numero.required'       => 'Monto Limite es Requerido',
                'email.required'                     => 'Correo Electronico es Requerido',
                'email.email'                        => 'Correo electronico no cumple con la estructura',
                'email.unique'                       => 'Correo Electronico ya se encuentra guardado en nuestro registro',
                'password.required'                  => 'Contrasena es requerido'
            ]
          );
        $datos             = $request->all();
        $datos['active']   = 1;
        $datos['password'] = Hash::make($request->get('password'));
    	$usuario           = $model->create($datos);
        if ($request->paga and $request->comision) {
            $sorteos = Sorteos::all();
            foreach ($sorteos as $sorteo) {
                $parametros             = new Parametros_sorteos;
                $parametros->paga       = $request->paga;
                $parametros->comision   = $request->comision;
                $parametros->idusuario  = $usuario->id;
                $parametros->idsorteo   = $sorteo->id;
                $parametros->devolucion = 0;
                if (!is_null($request->monto_limite_numero)) {

                    $parametros->monto_arranque = $request->monto_limite_numero;
                }
                $parametros->save();
            }
        }
        $controller = new ComandosController;
        $controller->startBalanceInit();
        //Creo el folder para las imagenes
        File::makeDirectory(public_path('/dist/images/profile/'. $usuario->id));
        return redirect()->route('user.index')->withSuccess(__('Usuario creado correctamente.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users/crud', [
            'users' => User::find($id)
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
        $datos              = $request->except(['_token', '_method']);
        if($request->hasFile('photo')) {
            $path           = public_path('dist/images/profile/'.$id);
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $file           = $request->file('photo');
            $fileName       = uniqid() . '_' . trim($file->getClientOriginalName());
            $datos['photo'] = $fileName;
            $file->move($path, $fileName);
        }
        User::where('id',$id)->update($datos);
        if (Auth::user()->es_administrador > 0) {
            return redirect()->route('user.index')->withSuccess(__('Usuario editado correctamente.'));
        } else {
            return redirect()->route('user.profile', $id)->withSuccess(__('Usuario editado correctamente.'));

        }
    }

    public function profile($id)
    {
        $venta_detalle = Venta_detalle::select('venta_detalle.*', 'venta_cabecera.fecha', 'venta_cabecera.hora', 'sorteos.nombre', 'sorteos.logo')
        ->leftjoin('venta_cabecera', 'venta_detalle.idventa_cabecera', '=', 'venta_cabecera.id')
        ->leftjoin('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')
        ->where('idusuario', $id)->latest()->take(5)->get();

        $juegos_hoy = Venta_cabecera::join('sorteos', 'venta_cabecera.idsorteo', '=', 'sorteos.id')->where([
            ['venta_cabecera.fecha', '>=', date('Y-m-d')],
            ['venta_cabecera.estatus', '=', 'abierto']
        ])->latest()->take(5)->get(['venta_cabecera.*', 'sorteos.nombre']);
        return view('users/profile', [
            'users' => User::find($id),
            'venta_detalle' => $venta_detalle,
            'juegos_hoy' => $juegos_hoy
        ]);
    }

    public function updprofile($id)
    {
        return view('users/updprofile', [
            'users' => User::find($id)
        ]);
    }

    public function changePassword($id)
    {
        return view('users/change-password')->with(['users' => User::find($id)]);
    }

    public function updatePassword(Request $request, $id)
    {
        $validated        = $request->validate([
            'oldPassword' => 'required',
            'password'    => 'required|min:8|confirmed',
        ]);
        $datos            = $request->all();
        $usuario          = User::find($id);
        $credentials      = [
            'email'       => $usuario->email,
            'password'    => $datos['oldPassword'],
        ];
        // Dump data
        if (Auth::user()->es_administrador > 0) {
            // Todo esta correcto procedo a actualizar la contraseña
            User::where('id', $id)->update(['password' => Hash::make($datos['password'])]);
            return redirect()->route('change-password', $id)->withSuccess(__('Contraseña Actualizada Correctamente.'));
        } else {
            if (Auth::attempt($credentials)) {
                // Todo esta correcto procedo a actualizar la contraseña
                User::where('id', $id)
                    ->update(['password' => Hash::make($datos['password'])]);
                return redirect()->route('change-password', $id)->withSuccess(__('Contraseña Actualizada Correctamente.'));
            } else {
                //Si no esta correcta la clave anterior debe enviar este mensaje
                Session::flash('message', "La antigua contraseña no es correcta!");
                return redirect()->route('change-password', $id);
            }
        }
    }

    public function dashboardUsuarios()
    {
        if (Auth::user()->es_administrador > 0) {
            if (Auth::user()->gender == 'female') {
                return redirect()->route('dashboard.admin')->withSuccess(__('Bienvenido'.Auth::user()->name.'!.'));
            } else {
                return redirect()->route('dashboard.admin')->withSuccess(__('Bienvenido'.Auth::user()->name.'!.'));
            }

        } else {

            $data = Venta_cabecera::where('venta_cabecera.fecha', '=', date('Y-m-d'))
            ->where('venta_cabecera.estatus', '=', 'abierto')
            ->get();
            $total = 0;
            $total_ganadores = 0;
            $juegos_abiertos = count($data);
            $clientes = Clientes::count();
            foreach ($data as $juegos) {
                $jugadas = Venta_detalle::where('idventa_cabecera', '=', $juegos->id)->where('idusuario', '=', Auth::user()->id)->sum('monto');
                $jugadas_reventadas = Venta_detalle::where('idventa_cabecera', '=', $juegos->id)->where('idusuario', '=', Auth::user()->id)->sum('monto_reventado');

                $total += $jugadas + $jugadas_reventadas;
            }
            $ultimas_ventas = Venta_cabecera::Join('venta_detalle', 'venta_cabecera.id', '=', 'venta_detalle.idventa_cabecera')
            ->select('venta_cabecera.*', 'venta_detalle.numero', 'venta_detalle.monto','venta_detalle.monto_reventado', 'venta_detalle.estatus as estatus_detalle')
            ->where('venta_cabecera.fecha', '=', date('Y-m-d'))
            ->where('venta_cabecera.estatus', '=', 'abierto')
            ->where('idusuario', '=', Auth::user()->id)
            ->get();

            // Data para las ganadoras
            $data_ganadoras = Venta_cabecera::where('venta_cabecera.fecha', '=', date('Y-m-d'))
            ->where('venta_cabecera.estatus', '=', 'finalizado')
            ->get();

            foreach ($data_ganadoras as $juegos_ganadores) {

                $jugadas_ganadoras = Venta_detalle::where('idventa_cabecera', '=', $juegos_ganadores->id)->where('idusuario', '=', Auth::user()->id)->sum('monto_ganador');
                $total_ganadores += $jugadas_ganadoras;

            }
            return view('users/dashboard', [
                // Specify the base layout.
                // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
                // The default value is 'side-menu'
                'transacciones' => Transacciones::where('idusuario', '=', Auth::user()->id)->where('tipo_concepto', '!=', 'comision')->orderBy('created_at', 'desc')->paginate(5),
                'sorteo_seleccionado' => null,
                'fecha_desde' => date('Y-m-d'),
                'jugadas' => $total,
                'ganadores' => $total_ganadores,
                'juegos_abiertos' => $juegos_abiertos,
                'clientes' => $clientes,
                'ultimas_ventas' => $ultimas_ventas,
                // 'layout' => 'side-menu'
            ]);
        }
    }

    public function dashboardAdministradores()
    {
        $total                  = 0;
        $total_ganadores        = 0;
        $tickets_apostados      = 0;
        $cabecera               = new Venta_cabecera;
        $transacc               = new Transacciones;
        $detalle                = new Venta_detalle;
        $data                   = $cabecera->filtrarPorSorteoyFechaIgual(date('Y-m-d'), 'all');
        $ultimas_ventas         = $cabecera->filtrarPorSorteosUltimasCinco('all', 'all');
        $transacciones          = $transacc->filtroPorUsuario('all');
        foreach ($data as $juegos) {
            $total             += $detalle->detallePorUsuario('all',$juegos->id)->sum('monto');
            $total_ganadores   += $detalle->detallePorUsuario('all',$juegos->id)->sum('monto_ganador');
            $tickets_apostados +=  count($detalle->detallePorUsuario('all',$juegos->id));
        }
        return view('users/dashadmin', [
            'transacciones'        => $transacciones,
            'sorteo_seleccionado'  => 'all',
            'sorteos'              => Sorteos::where('estatus', 1)->get(),
            'usuario_seleccionado' => 'all',
            'usuarios'             => User::where('active', 1)->get(),
            'fecha_desde'          => date('Y-m-d'),
            'jugadas'              => $total,
            'ganadores'            => $total_ganadores,
            'tickets_apostados'    => $tickets_apostados,
            'ultimas_ventas'       => $ultimas_ventas,
            'estatus'              => NULL,
        ]);
    }

    public function filtrodashboardAdministradores(Request $request)
    {
        //variables en 0 totales del dashboard
        $total              = 0;
        $total_ganadores    = 0;
        $tickets_apostados  = 0;
        $cabecera           = new Venta_cabecera;
        $transacc           = new Transacciones;
        $detalle            = new Venta_detalle;

        //validacion del primer request de sorteo
        if ($request->sorteos != 'all') {

            $data           = $cabecera->filtrarPorSorteoyFechaIgual(date('Y-m-d'), $request->sorteos);
            if ($request->usuarios != 'all') {
                $ultimas_ventas = $cabecera->filtrarPorSorteosUltimasCinco($request->sorteos, $request->usuarios);
            } else {
                $ultimas_ventas = $cabecera->filtrarPorSorteosUltimasCinco($request->sorteos, 'all');
            }
            $buscar_sorteo      = $ultimas_ventas[0]->sorteos->estatus ?? NULL;

        } else {

            $data               = $cabecera->filtrarPorSorteoyFechaIgual(date('Y-m-d'), 'all');
            if ($request->usuarios != 'all') {
                $ultimas_ventas = $cabecera->filtrarPorSorteosUltimasCinco('all', $request->usuarios);
            } else {
                $ultimas_ventas = $cabecera->filtrarPorSorteosUltimasCinco('all', 'all');
            }
            $buscar_sorteo      = NULL;

        }

        if ($request->usuarios != 'all') {

            $transacciones      = $transacc->filtroPorUsuario($request->usuarios);
        } else {

            $transacciones      = $transacc->filtroPorUsuario('all');

        }
        // Culminacion de loss Qrys despues de las validaciones
        foreach ($data as $juegos) {
            if ($request->usuarios != 'all') {
                $total             += $detalle->detallePorUsuario($request->usuarios,$juegos->id)->sum('monto');
                $total_ganadores   += $detalle->detallePorUsuario($request->usuarios,$juegos->id)->sum('monto_ganador');
                $tickets_apostados +=  count($detalle->detallePorUsuario($request->usuarios,$juegos->id));
            } else {
                $total             += $detalle->detallePorUsuario('all',$juegos->id)->sum('monto');
                $total_ganadores   += $detalle->detallePorUsuario('all',$juegos->id)->sum('monto_ganador');
                $tickets_apostados +=  count($detalle->detallePorUsuario('all',$juegos->id));
            }
        }
        return view('users/dashadmin', [
            'transacciones'          => $transacciones,
            'fecha_desde'            => date('Y-m-d'),
            'jugadas'                => $total,
            'ganadores'              => $total_ganadores,
            'ultimas_ventas'         => $ultimas_ventas,
            'sorteo_seleccionado'    => $request->sorteos,
            'sorteos'                => Sorteos::where('estatus', 1)->get(),
            'usuario_seleccionado'   => $request->usuarios,
            'usuarios'               => User::where('active', 1)->get(),
            'tickets_apostados'      => $tickets_apostados,
            'estatus'                => $buscar_sorteo,
        ]);
    }
    public function destroy($id)
    {
        User::where('id',$id)->update(['active' => 0]);
        return redirect()->route('user.index')->withSuccess(__('Usuario inactivado correctamente.'));

    }

    public function blockearUsuario($id){

        User::where('id',$id)->update(['block_user' => 1]);
        return redirect()->route('venta_sorteo.create')->withSuccess(__('Usuario Bloqueado correctamente.'));
    }

    public function desblockearUsuario(Request $request){

        if (Auth::user()->cod_unico == base64_encode($request->cod_unico)) {

            User::where('id',Auth::user()->id)->update(['block_user' => 0]);
            return redirect()->route('venta_sorteo.create')->withSuccess(__('Usuario Desbloqueado correctamente.'));
        } else {

            Session::flash('message', "La contraseña no es correcta!");
            return redirect()->route('venta_sorteo.create');

        }
    }

    public function generarKeyUser(Request $request, $id){

        User::where('id',$id)->update(['cod_unico' => base64_encode($request->cod_unico)]);
        return redirect()->route('user.profile', $id)->withSuccess(__('Contraseña Generada correctamente.'));
    }

    public function filterUsers(Request $request){

        if ($request->active == 'all') {
            return view('users/index', [
                'users'      => User::paginate(10),
                'active'     => 'all',
            ]);
        } elseif($request->active == 1){
            return view('users/index', [
                'users'      => User::where('active', 1)->get(),
                'active'     => 1,
            ]);
        } else {
            return view('users/index', [
                'users'      => User::where('active', 0)->get(),
                'active'     => 0,
            ]);

        }

    }
    public function ActivarUsers($id)
    {
        User::where('id',$id)->update(['active' => 1]);
        return redirect()->route('user.index')->withSuccess(__('Usuario Activado correctamente.'));

    }
}
