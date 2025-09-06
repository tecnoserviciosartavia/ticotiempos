<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sorteos;
use App\Models\Parametros_sorteos;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\Session;
use App\Models\Config_sorteo;
use App\Models\User;

class SorteosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorteo = Sorteos::orderBy('hora', 'asc')->get();
        return view('sorteos/index', [
            // Use the top-menu layout
            // Pass data to view
            'sorteos' => $sorteo,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @property string|null $filename
     * @property int $paga
     * @property string $comision
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate(
            [
                'nombre'          => 'required',
                'hora'            => 'required',
                'dias'            => 'required',
            ],
            [
                'nombre.required' => 'Nombre es Requerido',
                'hora.required'   => 'Hora es Requerido',
                'dias.required'   => 'Dias es Requerido',
            ]
        );
        $sorteos                 = new Sorteos;
        $sorteos->nombre         = $request->nombre;
        $sorteos->hora           = $request->hora;
        $sorteos->dias           = json_encode($request->dias);
        $sorteos->estatus        = 1;
        $sorteos->es_reventado   = $request->es_reventado;
        if ($request->monto_limite_numero > 0) {
            $sorteos->monto_limite_numero   = $request->monto_limite_numero;
        }
        $sorteos->usa_webservice = $request->usa_webservice;
        // Nueva validacion para cuando usa Webservices mando a guardar la URL y guardo el ultimo numero de sorteo
        // para asi sumarle +3 y saber el proximo para el webservice tica
        if ($request->usa_webservice > 0) {
            if ($request->url_webservice == 0) {
                Session::flash('message', "Selecciono Webservice debe escojer una opcion");
                return redirect()->route('sorteos.index');
            }
            $sorteos->url_webservice = $request->url_webservice;
            $numero_actual = $this->getNumeroSorteoDesdeTxt($request->hora);
            \Log::info('Numero de sorteo desde TXT asignado:', ['numero' => $numero_actual, 'hora' => $request->hora]);
            if ($numero_actual !== null) {
                $sorteos->numero_sorteo_webservice = $numero_actual;
            } else {
                $sorteos->numero_sorteo_webservice = 0;
                Session::flash('error', 'No se pudo obtener el número de sorteo desde el archivo resultados.txt.');
            }
        }
        $sorteos->created_at = date('Y-m-d');
        $sorteos->updated_at = date('Y-m-d');

        if($request->hasFile('logo')) {

            $path = public_path('dist/images/sorteos/');

            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }

            $file = $request->file('logo');

            $fileName = 'sorteo_' . uniqid().'.'. $file->getClientOriginalExtension();
            $file->move($path, $fileName);
        }

        if ($request->paga and $request->comision) {

            $paga = $request->paga;
            $comision = $request->comision;

        }
        $sorteos->save();

        if($request->hasFile('logo')) {
            Sorteos::where('id',$sorteos->id)->update(['logo' => $fileName]);
        }

        $config                      = New Config_sorteo;
        $config->idsorteo            = $sorteos->id;
        $config->restrinccion_numero = NULL;
        $config->restrinccion_monto  = NULL;
        $config->created_at          = date('Y-m-d');
        $config->updated_at          = date('Y-m-d');
        $config->save();


        if ($request->paga and $request->comision) {

            $usuarios = User::where([
                ['es_administrador', 0],
                ['active',1]
            ])->get();

            foreach ($usuarios as $usuario) {

                $parametros             = new Parametros_sorteos;
                $parametros->paga       = $paga;
                $parametros->comision   = $comision;
                $parametros->idusuario  = $usuario->id;
                $parametros->idsorteo   = $sorteos->id;
                $parametros->devolucion = 0;
                if (!is_null($request->monto_arranque)) {

                    $parametros->monto_arranque = $request->monto_arranque;
                }
                $parametros->save();
            }
        }
        return redirect()->route('sorteos.index')->withSuccess(__('Sorteo Agregado correctamente.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sorteo = Sorteos::find($id);
        if ($sorteo && $sorteo->usa_webservice > 0) {
            $numero_actual = $this->getNumeroSorteoDesdeTxt($sorteo->hora);
            if ($numero_actual !== null) {
                $sorteo->numero_sorteo_webservice = $numero_actual;
            }
        }
        return view('sorteos/edit', [
            'sorteo' => $sorteo,
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

        $validated = $request->validate(
            [
                'nombre'           => 'required',
                'hora'             => 'required',
                'dias'             => 'required',
                'estatus'          => 'required',
            ],
            [
                'nombre.required'  => 'Nombre es Requerido',
                'hora.required'    => 'Hora es Requerido',
                'dias.required'    => 'Dias es Requerido',
                'estatus.required' => 'Estatus es Requerido',
            ]
        );

        $sorteo                 = Sorteos::find($id);
        $sorteo->nombre         = $request->nombre;
        $sorteo->hora           = $request->hora;
        $sorteo->dias           = json_encode($request->dias);
        $sorteo->estatus        = $request->estatus;
        $sorteo->es_reventado   = $request->es_reventado;
        if ($request->monto_limite_numero > 0) {
            $sorteo->monto_limite_numero   = $request->monto_limite_numero;
        }
        $sorteo->usa_webservice = $request->usa_webservice;
        if ($request->usa_webservice > 0) {
            if ($request->url_webservice == 0) {
                Session::flash('message', "Selecciono Webservice debe escojer una opcion");
                return redirect()->route('sorteos.edit', $id);
            }
            $explode_hora = explode(':', $request->hora);
            $hora_sorteo = $explode_hora[0].':'.$explode_hora[1];
            $sorteo->url_webservice = $request->url_webservice;
            $numero_ganador = $this->getNumeroSorteoDesdeTxt($hora_sorteo);
            if ($numero_ganador === null) {
                Session::flash('error', 'No se pudo obtener el número de sorteo desde el archivo resultados.txt.');
                $sorteo->numero_sorteo_webservice = 0;
            } else {
                $sorteo->numero_sorteo_webservice = $numero_ganador;
            }
        } else {
            $sorteo->url_webservice = null;
            $sorteo->numero_sorteo_webservice = 0;
        }
        if($request->hasFile('logo')) {
            $path = public_path('dist/images/sorteos/');
            if ( ! file_exists($path) ) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('logo');
            $fileName = 'sorteo_' . uniqid().'.'. $file->getClientOriginalExtension();
            $file->move($path, $fileName);
        }
        $sorteo->save();
        if($request->hasFile('logo')) {
            Sorteos::where('id',$id)->update(['logo' => $fileName]);
        }
        return redirect()->route('sorteos.index')->withSuccess(__('Sorteo Editado correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Sorteos::find($id);
        $parametros = Parametros_sorteos::where('idsorteo', $id)->get();
        foreach ($parametros as $param) {
            Parametros_sorteos::destroy($param->id);
        }
        Sorteos::destroy($id);
        return redirect()->route('sorteos.index')->withSuccess(__('Sorteo Eliminado correctamente.'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search_restrinccion($id)
    {
        $config = Config_sorteo::where('idsorteo', '=', $id)->first();
	    return response()->json([
	      'data' => $config
	    ]);
    }
    /**
     * Store a newly created resource on table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function restrinccion(Request $request)
    {
        $validated                = $request->validate([
            'restrinccion_numero' => 'required',
            'restrinccion_monto'  => 'required',
        ]);
        $config                      = new Config_sorteo;
        $config->idsorteo            = $request->idsorteo;
        $config->restrinccion_numero = $request->restrinccion_numero;
        $config->restrinccion_monto  = $request->restrinccion_monto;
        $config->created_at          = date('Y-m-d');
        $config->updated_at          = date('Y-m-d');
        $config->save();
        Session::flash('success', "Configuracion Agregada correctamente.");
        return response()->json([ 'success' => true ]);
    }
       /**
     * Store a newly created resource on table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function restrinccionUpd(Request $request)
    {
        $validated                = $request->validate([
            'restrinccion_numero' => 'required',
            'restrinccion_monto'  => 'required',
        ]);
        $config                      = Config_sorteo::find($request->config_id);
        $config->restrinccion_numero = $request->restrinccion_numero;
        $config->restrinccion_monto  = $request->restrinccion_monto;
        $config->save();
        Session::flash('success', "Configuracion Editada correctamente.");
        return response()->json([ 'success' => true ]);
    }
       /**
     * Store a newly created resource on table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function search_config_parameters(Request $request)
    {
        $parametros = Parametros_sorteos::where('idsorteo', $request->idsorteo)->where('idusuario', $request->idusuario)->first();
        return response()->json([ 'success' => $parametros ]);
    }
    public function getNumeroSorteoDesdeTxt($hora)
    {
        $file = base_path('resultados.txt');
        if (!file_exists($file)) return null;
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        $hora_sorteo = substr($hora, 0, 5);
        foreach (["manana", "mediaTarde", "tarde"] as $turno) {
            if (!empty($data[$turno]) && isset($data[$turno]['fecha'])) {
                $explode = explode('T', $data[$turno]['fecha']);
                $hora_json = substr($explode[1], 0, 5);
                if ($hora_json == $hora_sorteo && isset($data[$turno]['numeroSorteo'])) {
                    return $data[$turno]['numeroSorteo'];
                }
            }
        }
        foreach (["tarde", "mediaTarde", "manana"] as $turno) {
            if (!empty($data[$turno]['numeroSorteo'])) {
                return $data[$turno]['numeroSorteo'];
            }
        }
        return null;
    }
}
