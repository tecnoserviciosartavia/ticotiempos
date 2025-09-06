<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Venta_cabecera;
use App\Models\Venta_detalle;
use App\Models\Parametros_sorteos;
use App\Models\Transacciones;
use App\Models\Resultados_parametros;
use App\Models\User_balance;
use Illuminate\Support\Facades\DB;

class RecalculateWinners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $venta_cabecera,$numero_ganador,$adicional_ganador;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idventa_cabecera, $numero_ganador, $adicional_ganador)
    {
        $this->venta_cabecera    = $idventa_cabecera;
        $this->numero_ganador    = $numero_ganador;
        $this->adicional_ganador = $adicional_ganador;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Juego en curso
        $juego = Venta_cabecera::find($this->venta_cabecera);
        // Leer el archivo de resultados generado por Node
        $file_path = base_path('resultados.txt');
        if (!file_exists($file_path)) {
            \Log::error('No se encontró el archivo de resultados: ' . $file_path);
            return;
        }
        $json = file_get_contents($file_path);
        $data = json_decode($json, true);
        if (!$data) {
            \Log::error('No se pudo decodificar el JSON de resultados.');
            return;
        }
        // Determinar el resultado según la hora del sorteo
        switch ($juego->sorteos->hora) {
            case '12:55:00':
                $numero  = $data['manana']['numero'];
                $bolita  = $data['manana']['colorBolita'];
                break;
            case '16:30:00':
                $numero  = $data['mediaTarde']['numero'];
                $bolita  = $data['mediaTarde']['colorBolita'];
                break;
            case '19:30:00':
                $numero  = $data['tarde']['numero'];
                $bolita  = $data['tarde']['colorBolita'];
                break;
            default:
                \Log::error('Hora de sorteo no reconocida: ' . $juego->sorteos->hora);
                return;
        }
        $letra = substr($bolita, 0,1);
        $consulta = Resultados_parametros::where('descripcion', '=', $letra)->first();
        //Actualizo la informacion
        Venta_cabecera::where('id', $this->venta_cabecera)
        ->update([
            'numero_ganador' => $numero,
            'adicional_ganador' => $consulta ? $consulta->id : null,
        ]);

        //Jugadas Ganadoras
        $jugadas_ganadoras = Venta_detalle::where([
            ['idventa_cabecera', '=', $this->venta_cabecera],
            ['es_ganador', '=', 1],
            ['numero', '=', $juego->numero_ganador],
        ])->get();

        if (count($jugadas_ganadoras) > 0) {

            foreach ($jugadas_ganadoras as $gano) {

                //Ubico la configuracion para el sorteo y usuario
                $parametros = Parametros_sorteos::where([
                    ['idusuario', '=', $gano->idusuario],
                    ['idsorteo', '=', $juego->idsorteo],
                ])->first();
                //calculo el monto ganador basado en la configuracion y lo que jugo el usuario
                $monto_ganador = $gano->monto * $parametros->paga;

                //Valido si la jugada fue reventado
                if ($gano->reventado > 0) {
                   //Ubico la configuracion para el reventado que salio con el juego
                    $result_parametros = Resultados_parametros::find($juego->adicional_ganador);
                    $monto_ganador += $gano->monto_reventado * $result_parametros->paga_resultado;
                }
                //Actualizo el estatus a Calculada correctamente y mantengo los demas parametros
                Venta_detalle::where('id',$gano->id)->update(['estatus' => 'apostada', 'es_ganador' => 0, 'monto_ganador' => '0.00000']);

                //Ubico la informacion del usuario para restarle el saldo de forma automatica puede quedar en negativo
                $usuario = DB::table('users')->where('id', $gano->idusuario)->first();

                //Actualizo el saldo nuevo del usuario posterior al que tenia
                DB::table('users')->where('id',$gano->idusuario)->update(['saldo_actual' => $usuario->saldo_actual + $monto_ganador]);
                $callback = [
                    'juego' => $juego, // el juego como tal para el momento hora fecha etc.
                    'parametros' => $parametros, // los parametros al momento del premio
                    'jugada' => $gano, // la jugada que gano
                    'usuario' => $usuario, // para saber el saldo anterior etc
                ];
                if ($gano->jugada_padre != NULL) {
                    $identificador = $gano->jugada_padre;
                } else {
                    $identificador = $gano->id;
                }
                Transacciones::create([
                    'idusuario' => $gano->idusuario,
                    'monto' => $monto_ganador,
                    'concepto' => 'Reverso Jugada Ganadora del ticket '.$identificador.' por el monto de '.$monto_ganador,
                    'tipo_concepto' => 'otro',
                    'json_dinamico' => json_encode($callback),
                ]);
                $user_balance = New User_balance;
                $user_balance->actualizarSaldoRecalculoConPremio($gano->idusuario, $monto_ganador);
            }
        }

        //Jugadas perdedoras
        $jugadas_perdedoras = Venta_detalle::where([
            ['idventa_cabecera', '=', $this->venta_cabecera],
            ['es_ganador', '=', 0],
            ['numero', '!=', $juego->numero_ganador],
        ])->get();

        if (count($jugadas_perdedoras) > 0) {

            foreach ($jugadas_perdedoras as $perdio) {

                //Actualizo el estatus a Calculada correctamente y mantengo los demas parametros
                Venta_detalle::where('id',$perdio->id)->update(['estatus' => 'apostada']);
            }
        }
        //Actualizo con los nuevos numeros
        Venta_cabecera::where('id', $this->venta_cabecera)
        ->update([
            'numero_ganador'    => $this->numero_ganador,
            'adicional_ganador' => $this->adicional_ganador,
        ]);
    }
}
